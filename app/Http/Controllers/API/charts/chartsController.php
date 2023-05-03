<?php

namespace App\Http\Controllers\Api\charts;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Worker;
use Illuminate\Http\Request;

class chartsController extends Controller
{
    public function getWorkersByMonth()
    {
        $counts = [];

        for ($month = 1; $month <= 12; $month++) {
            $workers = Worker::whereMonth('created_at', $month)->count();
            $counts[$month] = $workers;
        }

        return response()->json($counts);
    }
    public function getCustomerByMonth()
    {
        $counts = [];

        for ($month = 1; $month <= 12; $month++) {
            $customers = Customer::whereMonth('created_at', $month)->count();
            $counts[$month] = $customers;
        }

        return response()->json($counts);
    }
}
