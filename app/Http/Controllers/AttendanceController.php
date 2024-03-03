<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Designation;
use App\Models\User;

use App\Services\PaginateService;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {
        $paginate = new  PaginateService;
        $query = Attendance::query();
        $is_executive = request('is_executive') != 'false';
        $query->where('is_executive', $is_executive)->orderBy('date', 'desc');

        return $paginate(request(), $query);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $executive = request('executive');

        $users = User::query();

        $users->orderBy('_id', 'asc');
        $users->whereNot('corp_id', 0);


        if ($executive)
            $users->where('is_executive', $executive == 1);

        $data = $users
            ->orderBy('name', 'ASC')->get();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {

        $request->validate(['attend_list' => 'required|array']);
        try {
            DB::beginTransaction();
            $validated =  $request->validated();
            $validated['no_of_attendant'] = sizeof($request->attend_list);

            $validated['no_of_members']  = User::whereNot('corp_id', 0)
                ->count();
            $validated['date']  = $request->date ?? date('Y-m-d');

            $validated['percentage'] = round(($validated['no_of_attendant'] * 100) / $validated['no_of_members'], 2);

            $attendance = Attendance::create($validated);
            $att_list_array = $request['attend_list'];
            $att_list  = collect($att_list_array)->pluck('_id');

            $attendance->users()->attach($att_list->toArray());
            DB::commit();
        } catch (\Throwable $th) {
            return response($th->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        return $attendance->load('users');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $executive = $attendance->is_executive;
        $users = User::query();
        $users->orderBy('_id', 'asc');
        $users->whereNot('corp_id', 0);

        if ($executive)
            $users->where('is_executive', $executive == 1);

        return response([
            'users' => $users->get(),
            'attend_list' => $attendance->users,
            'is_executive' => $executive,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $request->validate(['attend_list' => 'required|array']);

        try {
            DB::beginTransaction();
            $validated =  $request->validated();


            $validated['no_of_attendant'] = sizeof($request->attend_list);
            $validated['no_of_members']  = User::whereNot('corp_id', 0)
                ->count();
            $validated['percentage'] = round(($validated['no_of_attendant'] * 100) / $validated['no_of_members'], 2);
            // $validated['percentage'] = foat()

            $attendance->update($validated);
            $att_list_array = $request['attend_list'];

            $att_list  = collect($att_list_array)->pluck('_id');
            logger($att_list->toArray());
            $attendance->users()->sync($att_list->toArray());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response($th->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return $this->index(request());
    }
}
