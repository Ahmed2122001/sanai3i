<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\API\categoryController;
use App\Http\Controllers\API\customer\CustomerController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\worker\WorkerController;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreAdminRequest;
use App\Http\Requests\admin\StoreCategoryRequest;
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
            $admin = Admin::orderBy('id', 'asc')->get();
            if ($admin) {
                return response()->json([
                    'success' => true,
                    'admins' => $admin,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 400);
            //throw $th;
        }
    }

    /**
     * add new admin
     */
    public function addAdmin(Request $request): JsonResponse
    {
        try {

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'email', 'unique:admin'],
                'password' => ['required', 'string', 'min:5'],
                'phone' => ['required', 'int'],
                'address' => ['required', 'string'],
                'image' => ['required', 'string'],
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validation->errors()->all(),
                ], 400);
            } else {
                $admin = Admin::create($request->all());
                if ($admin) {
                    return response()->json([
                        'success' => true,
                        'message' => 'admin added successfully',
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'some problems',
                    ], 400);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * admin fix account
     */
    public function fixAccount($id)
    {
        try {
            //fixing
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Remove the specified Customer from storage.
     */
    public function deleteCustomer($id): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($id)->delete();
            if ($customer) {
                return response()->json([
                    'success' => true,
                    'message' => 'customer deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'some problems',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }

    }

    /**
     * suspend the specified Customer.
     */
    public function suspendCustomer($id): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($id);
            if ($customer) {
                $customer->update(['status' => 'suspended']);
                return response()->json([
                    'success' => true,
                    'message' => 'customer suspended successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'some problems',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }

    }

    /**
     * activate the specified Customer.
     */
    public function activateCustomer($id): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($id);
            if ($customer) {
                $customer->update(['status' => 'active']);
                return response()->json([
                    'success' => true,
                    'message' => 'customer activated successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'some problems',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }

    }

    /**
     * Remove the specified worker from storage.
     */
    public function deleteWorker($id): JsonResponse
    {
        try {
            $worker = Worker::findOrFail($id)->delete();
            if ($worker) {
                return response()->json([
                    'success' => true,
                    'message' => 'worker deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'some problems',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * suspend the specified worker.
     */
    public function suspendWorker($id): JsonResponse
    {
        try {
            $worker = Worker::findOrFail($id);
            if ($worker) {
                $worker->update(['status' => 'suspended']);
                return response()->json([
                    'success' => true,
                    'message' => 'worker suspended successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'some problems',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * verify or activate worker
     */
    public function verifyWorker($id)
    {
        try {
            $worker = Worker::findOrFail($id);
            if ($worker) {
                $worker->update(['status' => 'active']);
                return response()->json([
                    'success' => true,
                    'message' => 'worker activated successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'some problems',
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * show the reports.
     */
    public function showReports(): JsonResponse
    {
        try {
            $reports = Report::all();
            if ($reports) {
                return response()->json([
                    'Reports' => $reports
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'some problems',
                ], 400);
            }
        } catch (\Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => $throwable->getMessage(),
            ], 404);
        }
    }

    /**
     * create category
     */
    public function createCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'min:3', 'max:255', 'unique:category'],
                'description' => ['required', 'min:3', 'max:255', 'nullable'],
                'image' => ['required', 'min:3', 'max:255', 'nullable'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->all()
                ], 422);
            }
            $category = Category::create($request->all());
            if (!$category) {
                return response()->json([
                    'message' => 'Category not created'
                ], 500);
            } else {
                return response()->json($category);
            }
        } catch (\Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => $throwable->getMessage(),
            ], 404);
        }
    }

    /**
     * get all accounts
     */
    public function showAllAccounts()
    {
        try {
            $customers = Customer::all();
            $workers = Worker::all();
            if ($customers && $workers) {
                return response()->json([
                    'Customers' => $customers,
                    'Workers' => $workers,
                ], 200);
            } else {
                return response()->json([
                    //'success'=>true,
                    'message' => 'some problems',
                ], 400);
            }
        } catch (\Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => $throwable->getMessage(),
            ], 404);
        }
    }
}
