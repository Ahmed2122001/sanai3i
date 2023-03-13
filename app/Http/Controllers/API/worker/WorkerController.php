<?php

namespace App\Http\Controllers\API\worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\worker\WorkerReqest;
use App\Models\Worker;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $worker=Worker::orderBy('id','asc')->get();
            //$worker=WorkerResource::collection(Worker::all());
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
                'phone'=>['required'],
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
                    'password'=>Hash::make($request->password),
//                    'password'=>$request->password,
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
    public function show($id): JsonResponse
    {
        $worker=Worker::find($id);
        if($worker){
            return response()->json([
//              'success'=>true,
                'worker'=>$worker,
            ],200);
        }else{
            return response()->json([
//                'success'=>false,
                'message'=>'worker not found',
                'status'=>'401'
            ],400);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(WorkerReqest $request, $id): JsonResponse
    {
        $request->validated();
        $worker= Worker::where('id',$id)->first();
//        $worker->update($request->all());
        if (!empty($request->name)){
            $worker->name=$request->name;
        }else{
            $worker->name=$worker->name;
        }
        if (!empty($request->email)){
            $worker->email=$request->email;
        }else{
            $worker->email=$worker->email;
        }
        if (!empty($request->password)){
            $worker->password=$request->password;
        }else{
            $worker->password=$worker->password;
        }
        if (!empty($request->address)){
            $worker->address=$request->address;
        }else{
            $worker->address=$worker->address;
        }
        if (!empty($request->image)){
            $worker->image=$request->image;
        }else{
            $worker->image=$worker->image;
        }
        if (!empty($request->city_id )){
            $worker->city_id=$request->city_id;
        }else{
            $worker->city_id=$worker->city_id;
        }
        if (!empty($request->filed_work  )){
            $worker->filed_work=$request->filed_work;
        }else{
            $worker->filed_work=$worker->filed_work;
        }
        if (!empty($request->description)){
            $worker->description=$request->description;
        }else{
            $worker->description=$worker->description;
        }
        if (!empty($request->portifolio)){
            $worker->portifolio=$request->portifolio;
        }else{
            $worker->portifolio=$worker->portifolio;
        }
        if (!empty($request->status)){
            $worker->status=$request->status;
        }else{
            $worker->status=$worker->status;
        }
        if (!empty($request->role)){
            $worker->role=$request->role;
        }else{
            $worker->role=$worker->role;
        }
        if (!empty($request->active_status)){
            $worker->active_status=$request->active_status;
        }else{
            $worker->active_status=$worker->active_status;
        }
        if (!empty($request->messenger_color)){
            $worker->messenger_color=$request->messenger_color;
        }else{
            $worker->messenger_color=$worker->messenger_color;
        }
        $result=$worker->save();
        if($result){
            return response()->json([
//              'success'=>true,
                'message'=>'worker updated',
                'worker'=>$worker
            ],200);
        }else{
            return response()->json([
//                'success'=>false,
                'message'=>'worker not found',
                'status'=>'401'
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $worker = Worker::where('id',$id)->first()->delete();
        if($worker){
            return response()->json([
//              'success'=>true,
                'message'=>'worker deleted',
                'status'=>'200'
            ],200);
        }else{
            return response()->json([
//                'success'=>false,
                'message'=>'worker not found',
                'status'=>'401'
            ],400);
        }


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

    public function suspendWorker($id) :JsonResponse
    {
        try {
            $worker=Worker::findOrFail($id)->delete();
            if ($worker) {
                $worker->update(['status'=>'available']);
                return response()->json([
                    'success'=>true,
                    'message'=>'worker suspended successfully',
                ],200);
            } else {
                return response()->json([
                    'success'=>true,
                    'message'=>'some problems',
                ],400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>$th->getMessage(),
            ],404);
        }

    }
}
