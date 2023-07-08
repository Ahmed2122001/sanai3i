<?php

namespace App\Http\Controllers\API\charts;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\Customer;
use App\Models\Requests;
use App\Models\Category;
use App\Models\Region;

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
        return response()->json(["workers"=> $counts_worker, "customer" => $counts_customer], 200);
    }
    public function getRequestsByMonth()
    {
        $counts = [];

        for ($month = 1; $month <= 12; $month++) {
            $requests = Requests::whereMonth('created_at', $month)->count();
            $counts[] = $requests;
        }
        return response()->json(["requests" => $counts], 200);
    }
    public function getWorkerByCategory()
    {
        $categories = Category::all();
        $categoryData = [];

        foreach ($categories as $category) {
            $count = Worker::where('category_id', $category->id)->count();
            $categoryData[] = [
                'category' => $category->name,
                'count' => $count,
            ];
        }

        return response()->json(["categories" => $categoryData], 200);
    }



    public function getWorkerByRegion()
    {
   $regions = Region::all();
       $categoryData = [];
       foreach ($regions as $region) {
          $count = Worker::where('city_id', $region->id)->count();
           $categoryData[] = [
               'city name' => $region->city_name,
                'count' => $count,
          ];
        }

       return response()->json(["regions" => $categoryData], 200);

    }

    public function getCustomerByRegion()
    {
        $regions = Region::all();
        $RegionData = [];
        foreach ($regions as $region) {
            $count = Customer::where('city_id', $region->id)->count();
            $RegionData[] = [
                'city name' => $region->city_name,
                'customer count' => $count,
            ];
        }

        return response()->json(["regions" => $RegionData], 200);
    }

    // get number of contracts in each region by customer id which has city id in customer table and id in region table
    public function getContractsByRegion()
    {
        $regions = Region::all();
        $contracts = Contract::all();
        $city_id = [];
        foreach ($contracts as $contract) {
            $customer_id = $contract->customer_id;
            $customer = Customer::find($customer_id);
            foreach ($regions as $region) {
                if ($customer->city_id == $region->id) {
                    $city_id[] = $region->id;
                }
            }
        }
        $RegionData = [];
        foreach ($regions as $region) {
            $count = count(array_keys($city_id, $region->id));
            $RegionData[] = [
                'city name' => $region->city_name,
                'contract count' => $count,
            ];
        }
        return response()->json(["regions" => $RegionData], 200);
    }

}
