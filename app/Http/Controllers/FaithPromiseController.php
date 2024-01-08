<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFaithPromiseRequest;
use App\Http\Requests\UpdateFaithPromiseRequest;
use App\Models\FaithPromise;
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
        $users->when('roles', fn ($q) => $q->whereNot('id', 1));

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
                'user_id' => request()->user()->id,
            ]);
            for ($i = 0; $i < sizeof($collection); $i++) {
                array_push($user_ids, $collection[$i]['id']);
                $data = [
                    'user_id' => $collection[$i]['id'],
                    'payable_type' => FaithPromise::class,
                    'payable_id' => $faithPromise->id,
                    'amount' => $collection[$i]['amount'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];


                $total += $collection[$i]['amount'];
                array_push($payment_details, $data);
            }

            $faithPromise->total_amount = $total;
            $faithPromise->save();

            $faithPromise->details()->insert($payment_details);

            $faithPromise->members()->attach($user_ids);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response($th->getMessage(), 400);
        }
        DB::rollBack();
        return $request->all();
    }

    /**
     * Display the specified resource.
     */
    public function show(FaithPromise $faithPromise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FaithPromise $faithPromise)
    {
        $fp_detail = $faithPromise
            ->details;
        $fp_detail->load('user');
        return $fp_detail;
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
            $faithPromiseData = [];

            $user_ids = [];
            $payment_details = [];

            // $faithPromise = FaithPromise::create([
            //     'user_id' => request()->user()->id,
            // ]);
            for ($i = 0; $i < sizeof($collection); $i++) {
                $payment = MemberPayment::find($collection[$i]['id']);
                $payment->update([
                    'amount' => $collection[$i]['amount']
                ]);
                $total += $collection[$i]['amount'];
                // array_push($user_ids, $collection[$i]['id']);
                // $data = [
                //     'user_id' => $collection[$i]['id'],
                //     'payable_type' => FaithPromise::class,
                //     'payable_id' => $faithPromise->id,
                //     'amount' => $collection[$i]['amount'],
                //     'created_at' => now(),
                //     'updated_at' => now(),
                // ];


                //     $total += $collection[$i]['amount'];
                //     array_push($payment_details, $data);
            }

            $faithPromise->total_amount = $total;

            $faithPromise->save();
            // $faithPromise->details()->insert($payment_details);

            // $faithPromise->members()->attach($user_ids);

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
