<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\API\customer\CustomerController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\worker\WorkerController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Report;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $admin=Admin::orderBy('id','asc')->get();
            if ($admin) {
                return response()->json([
                    'success'=>true,
                    'admins'=>$admin,
                ],200);
            }else{
                return response()->json([
                    'success'=>false,
                ],400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin): JsonResponse
    {
        //
    }
    /**
     * Remove the specified Customer from storage.
     */
    public function deleteCustomer($id) :JsonResponse
    {
        try {
            $customer=Customer::findOrFail($id)->delete();
            if ($customer) {
                return response()->json([
                    'success'=>true,
                    'message'=>'customer deleted successfully',
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
    /**
     * suspend the specified Customer.
     */
    public function suspendCustomer($id) :JsonResponse
    {
        try {
            $customer=Customer::findOrFail($id)->delete();
            if ($customer) {
                $customer->update(['status'=>'available']);
                return response()->json([
                    'success'=>true,
                    'message'=>'customer suspended successfully',
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
    /**
     * Remove the specified worker from storage.
     */
    public function deleteWorker($id) :JsonResponse
    {
        try {
            $worker=Worker::findOrFail($id)->delete();
            if ($worker) {
                return response()->json([
                    'success'=>true,
                    'message'=>'worker deleted successfully',
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
    /**
     * suspend the specified worker.
     */
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

    /**
     * show the reports.
     */
    public function showReports(): JsonResponse
    {
        try {
            $reports=Report::all();
            if ($reports){
                return response()->json([
                    'Reports'=>$reports
                ]);
            }else{
                return response()->json([
                    'success'=>true,
                    'message'=>'some problems',
                ],400);
            }
        }catch (\Throwable $throwable){
            return response()->json([
                'success'=>false,
                'message'=>$throwable->getMessage(),
            ],404);
        }
    }
    /**
     * create category
     */
    public function create(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'min:3', 'max:255', 'unique:category'],
                'description' => ['min:3', 'max:255', 'nullable'],
                'image' => ['min:3', 'max:255', 'nullable'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $validator->errors()->all()
                ], 422);
            }
            $category = Category::create($request->all());
            if (!$category) {
                return response()->json([
                    'message' => 'Category not created'
                ], 500);
            } else
                return response()->json($category);
        }catch (\Throwable $throwable){
            return response()->json([
                'success'=>false,
                'message'=>$throwable->getMessage(),
            ],404);
        }
    }
    /**
     * get all accounts
     */
    public function showAllAccounts(){
        try{
            $customers = Customer::all();
            $workers = Worker::all();
            if ($customers && $workers){
                return response()->json([
                    'Customers'=>$customers,
                    'Workers'=>$workers,
                ],200);
            }else{
                return response()->json([
                    //'success'=>true,
                    'message'=>'some problems',
                ],400);
            }
        }catch (\Throwable $throwable){
            return response()->json([
                'success'=>false,
                'message'=>$throwable->getMessage(),
            ],404);
        }
    }
}
