<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\Designation;
use App\Models\User;

use App\Services\PaginateService;
use Illuminate\Http\Request;
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
        if (request('is_executive'))
            $query->where('is_executive', request('is_executive'));
        return $paginate(request(), $query);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $executive = request('executive');
        $memberId = Designation::where('name', 'like', 'Member')->first()->id;

        $users = User::query();
        $users->orderBy('id', 'asc');
        $users->when('roles', fn ($q) => $q->whereNot('id', 1));

        if ($executive) {
            $users->whereHas('designations', function ($designation) use ($memberId) {
                $designation->whereNot('designations.id', $memberId);
            });
        } else {
            $users->whereHas('designations', function ($designation) use ($memberId) {
                $designation->where('designations.id', $memberId);
            });
        }

        return $users
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {

        $request->validate(['attend_list' => 'required|array']);
        // $request->validate(['attend_list' => 'present|array']);
        try {
            DB::beginTransaction();
            $validated =  $request->validated();
            $validated['no_of_attendant'] = sizeof($request->attend_list);
            // $validated['no_of_members']  = User::count();
            $all_memberes = Designation::where('name', 'like', 'Member')->first()?->users;
            $validated['no_of_members'] = $all_memberes->count();
            logger('all members: ', $all_memberes->toArray());
            logger('no of attendant: ' . $validated['no_of_attendant']);
            logger('no of members: ' . $validated['no_of_members']);
            $validated['percentage'] = ($validated['no_of_attendant'] * 100) / $validated['no_of_members'];
            $attendance = Attendance::create($validated);

            $att_list_array = $request['attend_list'];

            $att_list  = collect($att_list_array)->pluck('id');

            $attendance->users()->attach($att_list);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
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
        $memberId = Designation::where('name', 'like', 'Member')->first()->id;

        $users = User::query();
        $users->orderBy('id', 'asc');
        $users->when('roles', fn ($q) => $q->whereNot('id', 1));

        if ($executive) {
            $users->whereHas('designations', function ($designation) use ($memberId) {
                $designation->whereNot('designations.id', $memberId);
            });
        } else {
            $users->whereHas('designations', function ($designation) use ($memberId) {
                $designation->where('designations.id', $memberId);
            });
        }

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
            $validated['no_of_members']  = User::count();
            $validated['percentage'] = ($validated['no_of_attendant'] * 100) / $validated['no_of_members'];

            $attendance->update($validated);
            $att_list_array = $request['attend_list'];

            $att_list  = collect($att_list_array)->pluck('id');

            $attendance->users()->sync($att_list);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response($th->getMessage(), 400);
        }
    }

    public function update_collection(Request $request, Attendance $attendance)
    {
        $attendance->collection = $request->collection;
        $attendance->save();
        return $this->index($request);
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
