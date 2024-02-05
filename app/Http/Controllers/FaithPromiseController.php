<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaithPromiseRequest;
use App\Http\Requests\UpdateFaithPromiseRequest;
use App\Models\FaithPromise;
use App\Models\FaithPromisePayment;
use App\Models\MemberPayment;
use App\Models\User;
use App\Services\PaginateService;
use Illuminate\Http\Request;
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
        // return FaithPromise::create([
        //     'month' => $request->month,
        //     'user_id' => request()?->user()?->id,
        // ]);

        return;
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
        $faith_promises = $faithPromise->details()->with('user')->get();

        $fpData = $faithPromise->toArray();
        $paid_users = User::query()
            ->with(['faith_promise_payments' => fn ($fpp) => $fpp->where('faith_promise_id', $faithPromise->id)])
            // ->with(
            //     ['faith_promise_payments'
            //     => fn ($faith_promise) => $faith_promise->where('_id', $faithPromise->id)]
            // )
            ->whereNot('corp_id', 0)
            ->whereHas(
                'faith_promise_payments',
                fn ($faith_promise_payments) => $faith_promise_payments->where('faith_promise_id', $faithPromise->_id)
            )
            // ->whereHas('faith_promise_payments.faith_promise',
            // fn($faihtPromise) => $faithPromise->where('_id', $faithPromise->id);
            // )
            ->get();

        $fpData['paid']  = $paid_users;
        $fpData['pending']  = User::whereNot('corp_id', 0)
            ->whereDoesntHave(
                'faith_promise_payments',
                fn ($faith_promise_payments) => $faith_promise_payments->where('faith_promise_id', $faithPromise->_id)
            )->get();
        // foreach ($faith_promises as $faith_promise) {
        //     if ($faith_promise->amount == 0)
        //         array_push($fpData['pending'], $faith_promise);
        //     else
        //         array_push($fpData['paid'], $faith_promise);
        // }

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

        $total_amount = $faithPromise->details->sum('amount');
        $faithPromise->total_amount = $total_amount;
        $faithPromise->save();
        return $faithPromise;
        return;
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

    public function check_month_exists(Request $request)
    {


        $faithPromise =  FaithPromise::where('month', $request->date)
            ->first();
        if ($faithPromise) {
            return $faithPromise;
        }

        $faithPromise =  FaithPromise::create([
            'month' => $request->date,
            'user_id' => request()?->user()?->_id,
        ]);

        $user_ids = User::whereNot('corp_id', 0)->pluck('_id');
        logger($user_ids);
        try {
            $faithPromise->members()->attach($user_ids);
        } catch (\Throwable $th) {
            logger($th->getMessage());
        }
        return $faithPromise;
    }
}
