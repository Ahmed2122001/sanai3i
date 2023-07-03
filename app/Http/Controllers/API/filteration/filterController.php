<?php

namespace App\Http\Controllers\API\filteration;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
class filterController extends Controller
{
    //filter by category
    public function filterByCategory($id)
    {
        $worker = worker::select('worker.id','name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
            ->where('category_id', $id)
            ->get();
        return response()->json($worker);
    }
    //filter by region
    public function filterByRegion($id)
    {
        $worker = worker::select('name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
            ->where('city_id', $id)
            ->get();
        return response()->json($worker);
    }
    //filter by category and region
    public function filterByCategoryAndRegion(Request $request)
    {
        $category_id = $request->category_id;
        $city_id = $request->city_id;
        $worker = worker::select('worker.id','name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
            ->where('category_id', $category_id)
            ->where('city_id', $city_id)
            ->get();
        return response()->json($worker);
    }

    //filter by price rate and quality rate and time rate which all integers
    public function filterByPriceRateAndQualityRateAndTimeRate(Request $request)
    {
        $price_rate = $request->price_rate;
        $quality_rate = $request->quality_rate;
        $time_rate = $request->time_rate;
        $worker = worker::select('worker.id','name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
            ->join('rate', 'worker.id', '=', 'rate.worker_id')
            ->where('price_rate', $price_rate)
            ->where('quality_rate', $quality_rate)
            ->where('time_rate', $time_rate)
            ->get();
        return response()->json($worker);
    }

    //filter by data come from user which may contain category_id and city_id and price_rate and quality_rate and time_rate
    public function filter(Request $request){
        try{
            $query = worker::select('worker.id', 'name', 'phone', 'address', 'city_id', 'image', 'description', 'status');
            // check image

            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }
            if ($request->has('price_rate') || $request->has('quality_rate') || $request->has('time_rate')) {
                $query->leftJoin('rate', 'worker.id', '=', 'rate.worker_id');
            }
            if ($request->has('price_rate')) {
                $query->Where('price_rate', $request->price_rate);
            }
            if ($request->has('quality_rate')) {
                $query->Where('quality_rate', $request->quality_rate);
            }
            if ($request->has('time_rate')) {
                $query->Where('time_rate', $request->time_rate);
            }
            if ($query->get()->isEmpty()) {
                return response()->json(['message' => 'no data found'], 404);
            }
            $workers = $query->get();

            foreach ($workers as $worker) {
                if ($worker->image != null) {

                    $path = public_path($worker->image);
                    if (file_exists($path)) {
                        $file = file_get_contents($path);
                        $base64 = base64_encode($file);
                        $worker->image = $base64;
                    }
                }
            }
            return response()->json($workers);
        }catch (\Throwable $th){
            return response()->json([
                'success' => false,
                'message'=>'حدث خطأ ما',
                'errors' => $th->getMessage(),
            ], 404);
        }
    }

    public function converter($image){
        $path = public_path($image);
        if (file_exists($path)) {
            $file = file_get_contents($path);
            $base64 = base64_encode($file);
            $image = $base64;
        }
        return $image;
    }
    //return the nearest worker and best in quality, time and price
    public function recommendations($customer_id, $category_id)
    {
        try {
            $customer = Customer::where('id', $customer_id)->with('region')->first();
            $nearest_worker = null;
            $bestQuality = null;
            $bestPrice = null;
            $bestTime = null;

            if ($customer->region) {
                $nearest_worker = Worker::join('category', 'worker.category_id', '=', 'category.id')
                    ->join('region', 'worker.city_id', '=', 'region.id')
                    ->where('category_id', $category_id)
                    ->where('city_id', $customer->region->id)
                    ->select(
                        'worker.id',
                        'worker.name',
                        'worker.email',
                        'worker.phone',
                        'worker.address',
                        'category.name as category_name',
                        'region.city_name as region_name',
                        'worker.image',
                    )
                    ->first();

                if ($nearest_worker && $nearest_worker->image != null) {
                    $nearest_worker->image = $this->converter($nearest_worker->image);
                }
            }


            $bestQuality = Worker::join('rate', 'worker.id', '=', 'rate.worker_id')
                ->join('category', 'worker.category_id', '=', 'category.id')
                ->where('category_id', $category_id)
                ->select(
                    'worker.id',
                    'worker.name',
                    'worker.email',
                    'worker.phone',
                    'worker.address',
                    'worker.image',
                    'category.name as category_name',
                    DB::raw('ROUND(AVG(quality_rate), 1) as quality_rate'),
                )
                ->groupBy('worker.id', 'worker.name', 'worker.email', 'worker.phone', 'worker.address', 'worker.image', 'worker.category_id', 'category.name')
                ->orderBy('quality_rate', 'desc')
                ->first();

            if ($bestQuality && $bestQuality->image != null) {
                $bestQuality->image = $this->converter($bestQuality->image);
            }


            $bestPrice = Worker::join('rate', 'worker.id', '=', 'rate.worker_id')
                ->join('category', 'worker.category_id', '=', 'category.id')
                ->where('category_id', $category_id)
                ->select(
                    'worker.id',
                    'worker.name',
                    'worker.email',
                    'worker.phone',
                    'worker.address',
                    'worker.image',
                    'category.name as category_name',
                    DB::raw('ROUND(AVG(price_rate), 1) as avg_price_rate'),
                )
                ->groupBy('worker.id', 'worker.name', 'worker.email', 'worker.phone', 'worker.address', 'worker.image', 'worker.category_id', 'category.name')
                ->orderBy('avg_price_rate', 'desc')
                ->first();

            if ($bestPrice && $bestPrice->image != null) {
                $bestPrice->image = $this->converter($bestPrice->image);
            }



            $bestTime = Worker::join('rate', 'worker.id', '=', 'rate.worker_id')
                ->join('category', 'worker.category_id', '=', 'category.id')
                ->where('category_id', $category_id)
                ->select(
                    'worker.id',
                    'worker.name',
                    'worker.email',
                    'worker.phone',
                    'worker.address',
                    'worker.image',
                    'category.name as category_name',
                    DB::raw('ROUND(AVG(time_rate), 1) as avg_time_rate'),
                )
                ->groupBy('worker.id', 'worker.name', 'worker.email', 'worker.phone', 'worker.address', 'worker.image', 'worker.category_id', 'category.name')
                ->orderBy('avg_time_rate', 'desc')
                ->first();

            if ($bestTime && $bestTime->image != null) {
                $bestTime->image = $this->converter($bestTime->image);
            }
            
            if ($nearest_worker || $bestQuality || $bestPrice || $bestTime){
                return response()->json([
                    'success' => true,
                    'workers' =>[
                        'الاقرب' => $nearest_worker,
                        'الاعلي جودة' => $bestQuality,
                        'الافضل سعر' => $bestPrice,
                        'الافضل وقت' => $bestTime
                    ]
                ], 200);
            }else{
                return response()->json([
                    'success' => true,
                    'workers' =>[]
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ ما',
                'error' => $th->getMessage(),
            ], 500);
        }
    }



//    public function recommendations($customer_id, $category_id)
//    {
//        try {
//            $customer = Customer::where('id', $customer_id)->with('region')->first();
//            $workers = new Collection();
//
//            if ($customer->region) {
//                $nearest_worker = Worker::join('category', 'worker.category_id', '=', 'category.id')
//                    ->join('region', 'worker.city_id', '=', 'region.id')
//                    ->where('category_id', $category_id)
//                    ->where('city_id', $customer->region->id)
//                    ->select(
//                        'worker.id',
//                        'worker.name',
//                        'worker.email',
//                        'worker.phone',
//                        'worker.address',
//                        'category.name as category_name',
//                        'region.city_name as region_name',
//                        'worker.image'
//                    )
//                    ->first();
//
//                if ($nearest_worker->image != null) {
//                    $nearest_worker->image = $this->converter($nearest_worker->image);
//                }
//
//                $workers->push($nearest_worker);
//            }
//
//            $bestQuality = Worker::join('rate', 'worker.id', '=', 'rate.worker_id')
//                ->join('category', 'worker.category_id', '=', 'category.id')
//                ->where('category_id', $category_id)
//                ->select(
//                    'worker.id',
//                    'worker.name',
//                    'worker.email',
//                    'worker.phone',
//                    'worker.address',
//                    'worker.image',
//                    'category.name as category_name',
//                    DB::raw('ROUND(AVG(quality_rate), 1) as quality_rate')
//                )
//                ->groupBy('worker.id', 'worker.name', 'worker.email', 'worker.phone', 'worker.address', 'worker.image', 'worker.category_id', 'category.name')
//                ->orderBy('quality_rate', 'desc')
//                ->first();
//
//            if ($bestQuality->image != null) {
//                $bestQuality->image = $this->converter($bestQuality->image);
//            }
//
//            $workers->push($bestQuality);
//
//            $bestPrice = Worker::join('rate', 'worker.id', '=', 'rate.worker_id')
//                ->join('category', 'worker.category_id', '=', 'category.id')
//                ->where('category_id', $category_id)
//                ->select(
//                    'worker.id',
//                    'worker.name',
//                    'worker.email',
//                    'worker.phone',
//                    'worker.address',
//                    'worker.image',
//                    'category.name as category_name',
//                    DB::raw('ROUND(AVG(price_rate), 1) as avg_price_rate')
//                )
//                ->groupBy('worker.id', 'worker.name', 'worker.email', 'worker.phone', 'worker.address', 'worker.image', 'worker.category_id', 'category.name')
//                ->orderBy('avg_price_rate', 'desc')
//                ->first();
//
//            if ($bestPrice->image != null) {
//                $bestPrice->image = $this->converter($bestPrice->image);
//            }
//
//            $workers->push($bestPrice);
//
//            $uniqueWorkers = $workers->unique('id');
//
//            return response()->json([
//                'success' => true,
//                'category' => $nearest_worker->category_name,
//                'العمال المقترحون' => $uniqueWorkers
//            ], 200);
//        } catch (\Throwable $th) {
//            return response()->json([
//                'success' => false,
//                'message' => 'حدث خطأ ما',
//                'error' => $th->getMessage(),
//            ], 500);
//        }
//    }


}

