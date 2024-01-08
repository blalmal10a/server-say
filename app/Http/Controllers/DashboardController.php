<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\FaithPromise;
use App\Models\MemberPayment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        return [
            'Member zat' => User::count(),
            'Avg. Attendance' => number_format(Attendance::average('percentage'), 2) . '%',
            'Executive Meetings' => Attendance::where('is_executive', true)->count(),
            'Faith Promise belh khawm' => "₹" . FaithPromise::sum('total_amount'),
            // 'faith_promise_count' => FaithPromise::count(),
        ];
    }
}
