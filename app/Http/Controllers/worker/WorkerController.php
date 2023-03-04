<?php

namespace App\Http\Controllers\worker;

use App\Http\Controllers\Controller;
use App\Http\Resources\worker\WorkerResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Worker;
use Illuminate\Support\Facades\Validator;


class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            //$worker=Worker::orderBy('id','asc')->get();
            $worker=WorkerResource::collection(Worker::all());
            if ($worker) {
                return response()->json([
//                    'success'=>true,
                    'workers'=>$worker,
                ],200);
            }else{
                return response()->json([
//                    'success'=>false,
                ],400);
            }
        } catch (\Throwable $th) {
            return response()->json([
//                'success'=>false,
                'message'=>$th->getMessage(),
            ],400);
            //throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validation=Validator::make($request->all(),[
                'name'=>['required','string','max:255'],
                'email'=>['required','string','max:255','email','unique:worker'],
                'password'=>['required','string','min:5'],
                'phone'=>['required','int'],
                'address'=>['required','string'],
                'image'=>['required','string'],
                'description'=>['required','string','max:255'],
                'portifolio'=>['required','string','max:255'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    //'success'=>false,
                    'message'=>$validation->errors()->all(),
                ],400);
            }else{
                $worker=Worker::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    //'password'=>Hash::make($request->password),
                    'password'=>$request->password,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'image'=>$request->image,
                    'description'=>$request->description,
                    'portifolio'=>$request->portifolio,
                ]);
                if ($worker){
                    return response()->json([
                        //'success'=>true,
                        'message'=>"your request added and admin will check it",
                    ],200);
                }else{
                    return response()->json([
                        //'success'=>true,
                        'message'=>'some problem',
                    ],401);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>true,
                'message'=>$th->getMessage(),
            ],404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Worker $worker): JsonResponse
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Worker $worker): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worker $worker): JsonResponse
    {

    }

    public function delete($id) :JsonResponse
    {
        try {
            $worker=Worker::findOrFail($id)->delete();
            if ($worker) {
                return response()->json([
                    'message'=>'Worker deleted successfully',
                ],200);
            } else {
                return response()->json([
//                    'success'=>true,
                    'message'=>'some problems',
                ],401);
            }

        } catch (\Throwable $th) {
            return response()->json([
//                'success'=>false,
                'message'=>$th->getMessage(),
            ],404);
        }

    }
}
