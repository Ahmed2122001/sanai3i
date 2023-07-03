<?php

namespace App\Http\Controllers\API\charts;

use App\Http\Controllers\Controller;
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

            $counts = [];
            $categories_id = [];

            $categories = Worker::select('category_id')->distinct()->get();
            $cat=Category::select('id')->distinct()->get();
            $c=[];
            foreach ($categories as $category) {
                $count = Worker::where('category_id', $category->category_id)->count();
                $categories_id[] = $category->category_id;
                $counts[] = $count;
            }
            foreach ($cat as $category) {
               $c[]=$category->id;
            }
            return response()->json(["categories" => $c,"IdCounted"=>$categories_id ,"counts" => $counts], 200);

    }
    public function getWorkerByRegion()
    {

                $counts = [];
                $regions = Worker::select('city_id')->distinct()->get();
                $regions_id = [];
                $AllRegions = Region::select('id')->distinct()->get();
                $AllR=[];
                foreach ($regions as $region) {
                    $count = Worker::where('city_id', $region->city_id)->count();
                    $counts[] = $count;
                    $regions_id[] = $region->city_id;
                }
                foreach ($AllRegions as $region) {
                    $AllR[]=$region->id;
                }
                return response()->json(["All Regions"=>$AllR,"regions" => $regions_id, "counts" => $counts], 200);

    }
    public function getCustomerByRegion()
    {
            $counts = [];
            $regions = Customer::select('city_id')->distinct()->get();
            $AllRegions = Region::select('id')->distinct()->get();
            $AllR=[];
            $region_id = [];

            foreach ($regions as $region) {
                $count = Customer::where('city_id', $region->city_id)->count();
                $counts[] = $count;
                $region_id[] = $region->city_id;
            }
            foreach ($AllRegions as $region) {
                $AllR[]=$region->id;
            }
            return response()->json(["All Regions"=>$AllR,"regions" => $region_id, "counts" => $counts], 200);


    }

}
