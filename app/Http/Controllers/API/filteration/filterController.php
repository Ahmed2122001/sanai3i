<?php

namespace App\Http\Controllers\API\filteration;

use App\Http\Controllers\Controller;
use App\Models\worker;
use Illuminate\Http\Request;

class filterController extends Controller
{
    //filter by category
    public function filterByCategory($id)
    {
        $worker = worker::select('name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
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
        $worker = worker::select('name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
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
        $worker = worker::select('name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
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
            $query = worker::select('id', 'name', 'phone', 'address', 'city_id', 'image', 'description', 'status');
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
}

