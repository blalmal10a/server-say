<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaithPromiseRequest;
use App\Http\Requests\UpdateFaithPromiseRequest;
use App\Models\FaithPromise;
use App\Models\FaithPromisePayment;
use App\Models\MemberPayment;
use App\Models\User;
use App\Services\PaginateService;
use Illuminate\Support\Facades\DB;

class FaithPromiseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faith_promises = FaithPromise::query();
        $pagination = new PaginateService;
        return $pagination(request(), $faith_promises);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::query();
        $users->whereNot('corp_id', 0);

        return $users
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaithPromiseRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $collection = $validated['faith_promise_data'];

            $total = 0;
            $faithPromiseData = [];

            $user_ids = [];
            $payment_details = [];

            $faithPromise = FaithPromise::create([
                'month' => $request->month,
                'user_id' => request()?->user()?->id,
            ]);
            for ($i = 0; $i < sizeof($collection); $i++) {
                array_push($user_ids, $collection[$i]['_id']);
                $amount = 0;
                if (isset($collection[$i]['amount']))
                    $amount = $collection[$i]['amount'] ?? 0;

                $data = [
                    'user_id' => $collection[$i]['_id'],
                    'faith_promise_id' => $faithPromise->id,
                    'amount' => $amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];


                $total += $amount;

                array_push($payment_details, $data);
            }

            $faithPromise->total_amount = $total;
            $faithPromise->save();

            foreach ($payment_details as $payment) {
                FaithPromisePayment::create($payment);
            }

            // $faithPromise->details()->insert($payment_details);

            $faithPromise->members()->attach($user_ids);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response($th->getMessage(), 400);
        }

        return $request->all();
    }

    /**
     * Display the specified resource.
     */
    public function show(FaithPromise $faithPromise)
    {
        // return $faithPromise->load([
        //     'details' => fn ($detail) => $detail->where('amount', '=', 0),
        //     'details.user'
        // ]);
        $faith_promises = $faithPromise->details()->with('user')->get();

        $fpData = $faithPromise->toArray();
        $fpData['paid']  = [];
        $fpData['pending']  = [];
        foreach ($faith_promises as $faith_promise) {
            if ($faith_promise->amount == 0)
                array_push($fpData['pending'], $faith_promise);
            else
                array_push($fpData['paid'], $faith_promise);
        }

        return $fpData;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaithPromise $faithPromise)
    {
        // $fp_detail = $faithPromise
        //     ->details;
        // $fp_detail->load('user');
        // return [

        // ];

        //
        return $faithPromise->load('details.user');
        // return $faithPromise->details;
        // return $faithPromise->load('details');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaithPromiseRequest $request, FaithPromise $faithPromise)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $collection = $validated['faith_promise_data'];
            $total = 0;
            logger($request);
            if ($request->pending) {
                $total  = $faithPromise->total_amount;
            }
            $faithPromiseData = [];

            $user_ids = [];
            $payment_details = [];

            for ($i = 0; $i < sizeof($collection); $i++) {
                $payment = FaithPromisePayment::find($collection[$i]['_id']);
                $amount = 0;
                if (isset($collection[$i]['amount']))
                    $amount = $collection[$i]['amount'] ?? 0;
                $payment->update([
                    'amount' => $amount
                ]);
                $total += $amount;
            }

            $faithPromise->total_amount = $total;
            $faithPromise->month = $request->month;


            $faithPromise->save();

            DB::commit();

            return $faithPromise;
        } catch (\Throwable $th) {
            DB::rollBack();
            return response($th->getMessage(), 400);
        }
        DB::rollBack();
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaithPromise $faithPromise)
    {
        $faithPromise->delete();
        return $this->index(request());
    }
}
