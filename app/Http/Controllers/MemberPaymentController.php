<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberPaymentRequest;
use App\Http\Requests\UpdateMemberPaymentRequest;
use App\Models\MemberPayment;

class MemberPaymentController extends Controller
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
    public function store(StoreMemberPaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberPayment $memberPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberPayment $memberPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberPaymentRequest $request, MemberPayment $memberPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberPayment $memberPayment)
    {
        //
    }
}
