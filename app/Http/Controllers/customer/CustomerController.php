<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\customer\StoreCustomerRequest;
use App\Http\Resources\customer\CustomerResource;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            //$customer=Customer::orderBy('id','asc')->get();
            $customer=CustomerResource::collection(Customer::all());
            if ($customer) {
                return response()->json([
                    //'success'=>true,
                    'customers'=>$customer,
                ],200);
            }else{
                return response()->json([
                    //'success'=>false,
                ],400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>false,
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
                'email'=>['required','string','max:255','email','unique:customer'],
                'password'=>['required','string','min:5'],
                'phone'=>['required','int'],
                'address'=>['required','string'],
                'image'=>['required','string'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all(),
                ],200);
            }else{
                $customer=Customer::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    //'password'=>Hash::make($request->password),
                    'password'=>$request->password,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'image'=>$request->image,
                ]);
                if ($customer){
                    return response()->json([
                        //'success'=>true,
                        'message'=>"Customer added",
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
        try {
            //$customer=Customer::orderBy('id','asc')->get();
            $customer=CustomerResource::collection(Customer::all());
            if ($customer) {
                return response()->json([
                    //'success'=>true,
                    'customers'=>$customer,
                ],200);
            }else{
                return response()->json([
                    //'success'=>false,
                ],400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>false,
                'message'=>$th->getMessage(),
            ],400);
            //throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $customers=Customer::findOrFail($id);
            $validation=Validator::make($request->all(),[
                'name'=>['string','max:255'],
                'email'=>['string','max:255','email','unique:customer'],
                'password'=>['string','min:5'],
                'phone'=>['int'],
                'address'=>['string'],
                'image'=>['string'],
            ]);
            if ($validation->fails()){
                return response()->json([
                    //'success'=>false,
                    'message'=>$validation->errors()->all(),
                ],400);
            }else{
                if (!empty($request->name)){
                    $customers->name=$request->name;
                }else{
                    $customers->name=$customers->name;
                }
                if (!empty($request->email)){
                    $customers->email=$request->email;
                }else{
                    $customers->email=$customers->email;
                }
                if (!empty($request->password)){
                    $customers->password=$request->password;
                }else{
                    $customers->password=$customers->password;
                }
                if (!empty($request->address)){
                    $customers->address=$request->address;
                }else{
                    $customers->address=$customers->address;
                }
                if (!empty($request->image)){
                    $customers->image=$request->image;
                }else{
                    $customers->image=$customers->image;
                }

                //dd($customers);
//                $customers->email=$request->email;
//                $customers->password=$request->password;
//                $customers->phone=$request->phone;
//                $customers->address=$request->address;
//                $customers->image=$request->image;
                $result=$customers->save();
                if ($result){
                    return response()->json([
                        //'success'=>true,
                        'message'=>$customers,
                    ],200);
                }else{
                    return response()->json([
                        //'success'=>true,
                        'message'=>'some problem',
                    ],404);
                }
            }
        }catch (Throwable $th){
            return response()->json([
                //'success'=>false,
                'message'=>$th->getMessage(),
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        //
    }
    public function delete($id) :JsonResponse
    {
        try {
            $customer=Customer::findOrFail($id)->delete();
            if ($customer) {
                return response()->json([
                    'success'=>true,
                    'message'=>'customer deleted successfully',
                ]);
            } else {
                return response()->json([
                    'success'=>true,
                    'message'=>'some problems',
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>$th->getMessage(),
            ]);
        }

    }
}
