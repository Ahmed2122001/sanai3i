<?php

namespace App\Http\Controllers\Api\requests;

use App\Http\Controllers\Controller;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestsController extends Controller
{
    public function index()
    {
        return response()->json(Requests::all(), 200);
    }
    public function show($id)
    {
        $request = Requests::find($id);
        if (is_null($request)) {
            return response()->json(["message" => "Record not found!"], 404);
        }
        return response()->json($request, 200);
    }
    public function store(Request $request)
    {
        $validation = validator::make($request->all(), [
            'customer_id' => 'required',
            'worker_id' => 'required',
            'description' => 'required',

        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        } else {
            $request = Requests::create($request->all());
            return response()->json("تم تسجيل الطلب بنجاح ", 201);
        }
    }
}
