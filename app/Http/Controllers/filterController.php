<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\region;
use App\Models\worker;

class filterController extends Controller
{
    public function filterByCategory($id)
    {
        $worker = worker::select('name', 'phone', 'address', 'city_id', 'image', 'description', 'status')
            ->where('category_id', $id)
            ->get();
        return response()->json($worker);
    }
}
