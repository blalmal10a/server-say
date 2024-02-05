<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaithPromisePaymentRequest;
use App\Http\Requests\UpdateFaithPromisePaymentRequest;
use App\Models\FaithPromisePayment;

class FaithPromisePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreFaithPromisePaymentRequest $request)
    {
        $validated = $request->validated();
        return FaithPromisePayment::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'faith_promise_id' => $request->faith_promise_id,
            ],
            [
                'amount' => $request->amount
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FaithPromisePayment $faithPromisePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaithPromisePayment $faithPromisePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaithPromisePaymentRequest $request, FaithPromisePayment $faithPromisePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaithPromisePayment $faithPromisePayment)
    {
        //
    }
}
