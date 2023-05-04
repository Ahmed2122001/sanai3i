<?php

namespace App\Http\Controllers\Api\charts;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Worker;
use Illuminate\Http\Request;
use App\Models\Requests;
use PhpParser\Node\Expr\FuncCall;

class ChartsController extends Controller
{
    public function getUsersByMonth()
    {
        $counts_worker = [];
        $counts_customer = [];


        for ($month = 1; $month <= 12; $month++) {
            $workers = Worker::whereMonth('created_at', $month)->count();
            $counts_worker[] = $workers;
            $customers = Customer::whereMonth('created_at', $month)->count();
            $counts_customer[] = $customers;
        }
        return response()->json(["workers", $counts_worker, "customer", $counts_customer], 200);
    }
    public function getRequestsByMonth()
    {
        $counts = [];

        for ($month = 1; $month <= 12; $month++) {
            $requests = Requests::whereMonth('created_at', $month)->count();
            $counts[] = $requests;
        }
        return response()->json(["requests", $counts], 200);
    }
}
