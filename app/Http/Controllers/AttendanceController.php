<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
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
        return $paginate(request(), $query);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return User::all();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
