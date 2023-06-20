<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Controller;
use App\Mail\AdminNotification;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\MailBody;
use App\Models\Report;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
     * suspend the specified Customer.
     */
    public function suspendCustomer($id): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($id);
            if ($customer) {
                $customer->status = 'deactive';
                $customer->save();
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
                $customer->status = 'active';
                $customer->save();
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
     * suspend the specified worker.
     */
    public function suspendWorker($id): JsonResponse
    {
        try {
            $worker = Worker::findOrFail($id);
            if ($worker) {
                $worker->status = 'deactive';
                $worker->save();
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
                $worker->status = 'active';
                $worker->save();
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
    /*
     * show workers requests
     */
    public function showWorkersRequests()
    {
        try {
            $workers = Worker::where('status', 'deactive1')->get();
            if ($workers) {
                return response()->json([
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

    /*
     * show workers rates
     */
    //todo: show workers rates
    public function showWorkersRates(){
        try {
            // get all workers with their rates
            $workers = Worker::orderBy('id', 'asc')->with('rate')->get();
            $rate = DB::table('rate')
                ->select('rate.worker_id',
                    //DB::raw('AVG(rate.price_rate) as avg_money_rate'),
                    // round to nearest half number ex: 3.5 , 4.5 , 5 if it was 3.1 it will be 3
                    DB::raw('ROUND(AVG(rate.time_rate)*2)/2 as avg_time_rate'),
                    DB::raw('ROUND(AVG(rate.quality_rate)*2)/2 as avg_quality_rate'),
                    DB::raw('ROUND(AVG(rate.price_rate)*2)/2 as avg_money_rate'),
                    DB::raw('ROUND((AVG(rate.time_rate)+AVG(rate.quality_rate)+AVG(rate.price_rate))/3) as avg_rate'),
                    'worker.name',
                    'worker.email',
                    'worker.phone')
                ->join('worker', 'rate.worker_id', '=', 'worker.id')
                ->groupBy('rate.worker_id', 'worker.name', 'worker.email', 'worker.phone')
                ->get();


            if ($workers && $rate) {
                return response()->json([
                    'Workers' => $rate,
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
    /*
     * notify workers
     */
    public function notifyWorkers(Request $request){
        try {
            $workers = Worker::all()->where('status','active');
            $mailBody = new MailBody();
            $mailBody->message = $request->message;
            foreach ($workers as $worker){
                $mailBody->name = $worker->name;
                Mail::to($worker->email)->send(new AdminNotification($mailBody));
            }
            return response()->json([
                'success'=>true,
                'message'=>'notified successfully',
            ],200);
        } catch (\Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => $throwable->getMessage(),
            ], 404);
        }
    }
}
