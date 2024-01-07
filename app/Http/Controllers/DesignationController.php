<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Designation;
use App\Services\PaginateService;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Designation::query();
        $pagination = new PaginateService;
        return $pagination(request(), $query);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDesignationRequest $request)
    {
        $highest_order = Designation::orderBy('order', 'desc')->first();

        $order = $highest_order?->order ?? 0 + 1;

        $validated = $request->validated();
        $validated['order'] = $order;
        Designation::create($validated);
        return $this->index($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        $validated = $request->validated();
        $designation->update($validated);
        return $this->index($request);
        //update order method a hranign a awm thei ang
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
        return $this->index(request());
    }
}
