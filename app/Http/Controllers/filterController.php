<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\region;
use App\Models\worker;

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
    public function filterByCategoryAndRegion($category_id, $city_id)
    {
        $worker = worker::select('name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
            ->where('category_id', $category_id)
            ->where('city_id', $city_id)
            ->get();
        return response()->json($worker);
    }
    //filter by rate
    public function filterByRate($rate)
    {
        $worker = worker::select('name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
            ->where('rate', $rate)
            ->get();
        return response()->json($worker);
    }
}
