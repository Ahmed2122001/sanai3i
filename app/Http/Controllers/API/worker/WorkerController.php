<?php

namespace App\Http\Controllers\API\worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\worker\WorkerReqest;
use App\Models\Contract;
use App\Models\Portfolio;
use App\Models\Worker;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Region;


use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;


class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $worker = Worker::orderBy('id', 'asc')->get();
            //$worker=WorkerResource::collection(Worker::all());
            if ($worker) {
                return response()->json([
                    //                    'success'=>true,
                    'workers' => $worker,
                ], 200);
            } else {
                return response()->json([
                    //                    'success'=>false,
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                //                'success'=>false,
                'message' => $th->getMessage(),
            ], 400);
            //throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'email', 'unique:worker'],
                'password' => ['required', 'string', 'min:5'],
                'phone' => ['required'],
                'address' => ['required', 'string'],
                'image' => ['required', 'string'],
                'description' => ['required', 'string', 'max:255'],
                'portifolio' => ['required', 'string', 'max:255'],
            ]);
            if ($validation->fails()) {
                return response()->json([
                    //'success'=>false,
                    'message' => $validation->errors()->all(),
                ], 400);
            } else {
                $worker = Worker::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    //'password'=>$request->password,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'image' => $request->image,
                    'description' => $request->description,
                    'portifolio' => $request->portifolio,
                ]);
                if ($worker) {
                    return response()->json([
                        //'success'=>true,
                        'message' => "تم اضافة العامل بنجاح سيقوم المشرف بالتحقق عليه",
                    ], 200);
                } else {
                    return response()->json([
                        //'success'=>true,
                        'message' => 'لم يتم اضافة العامل',
                    ], 401);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>true,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $worker = Worker::find($id);
        if ($worker) {
            return response()->json([
                //              'success'=>true,
                'worker' => $worker,
            ], 200);
        } else {
            return response()->json([
                //                'success'=>false,
                'message' => 'worker not found',
                'status' => '401'
            ], 400);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(Request $request, $id)
    {
        //        dd($request->all());
        // Validate the input using Laravel's built-in validation rules
        //        dd($request->all());
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        // Find the worker with the specified ID in the database
        $worker = Worker::findOrFail($id);
        //        dd($worker);
        // Verify that the old password matches the one in the database
        if (!Hash::check($request->input('old_password'), $worker->password)) {
            return response()->json(['error' => 'Invalid old password'], 401);
        }

        // Update the worker's password with the new one
        $worker->password = Hash::make($request->input('new_password'));
        $worker->save();

        // Return a success response
        return response()->json(['message' => 'Password updated successfully']);
    }

    public function delete($id): JsonResponse
    {
        try {
            $worker = Worker::findOrFail($id)->delete();
            if ($worker) {
                return response()->json([
                    'message' => 'Worker deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    //                    'success'=>true,
                    'message' => 'some problems',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                //                'success'=>false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }
    public function update_porofile(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string|max:255|unique:category,name,' . $id,
                'phone' => 'string|max:11|min:11',
                'address' => 'string|between:4,100',
                'city_id' => 'exists:region,id',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $worker = Worker::find($id);
            if ($worker) {
                if ($request->hasFile('image')) {
                    // Get the uploaded image file
                    $uploadedFile = $request->file('image');

                    // Generate a unique filename for the uploaded image
                    $filename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

                    // Store the uploaded image in the public/images directory
                    $path = $uploadedFile->move('images', $filename);

                    // Delete the old image file
                    !is_null($worker->image) && Storage::delete($worker->image);

                    // Update the category image path
                    $worker->image = $path;
                }
                if ($request->name) {
                    $worker->name = $request->name;
                }
                if ($request->phone) {
                    $worker->phone = $request->phone;
                }
                if ($request->address) {
                    $worker->address = $request->address;
                }
                if ($request->city_id) {
                    $worker->city_id = $request->city_id;
                }
                if ($request->category_id) {
                    $worker->category_id = $request->category_id;
                }
            }else{
                return response()->json([
                    'message' => 'Worker not found',
                ], 404);
            }
            $worker->save();
            if ($worker) {
                return response()->json([
                    'message' => 'تم تعديل البيانات بنجاح',

                ], 200);
            } else {
                return response()->json([
                    'message' => 'حدث خطأ ما',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'حدث خطأ ما',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    public function showMyProfile($id)
    {
        try{
            // get worker by id and his category and city and region and his rates and his portfolio
            $worker = Worker::where('id', $id)->with('category', 'region', 'rate', 'portfolio')->first();

            if ($worker) {
                $category = [
                    'id' => $worker->category->id,
                    'name' => $worker->category->name,
                ];
                $region = [
                    'id' => $worker->region->id,
                    'city_name' => $worker->region->city_name,
                ];
                $rate=DB::table('rate')
                    ->select('worker_id',
                        // round to get 1 number after point if it was 3.1 it will be 3 and if it was 3.4 it will be 3.5
                        DB::raw('ROUND(AVG(quality_rate),1) as quality_rate'),
                        DB::raw('ROUND(AVG(time_rate),1) as avg_time_rate'),
                        DB::raw('ROUND(AVG(price_rate),1) as avg_price_rate'),
                        DB::raw('ROUND((AVG(quality_rate) + AVG(time_rate) + AVG(price_rate)) / 3) as avg_rate'))
                    ->where('worker_id',$id)
                    ->groupBy('worker_id')
                    ->get();
                $data = [
                    'id' => $worker->id,
                    'name' => $worker->name,
                    'email' => $worker->email,
                    'phone' => $worker->phone,
                    'address' => $worker->address,
                    'created_at' => $worker->created_at,
                    'description' => $worker->description,
                    'initial_price'=>$worker->initial_price,
                    'Category' => $category,
                    'Region' => $region,
                ];
                // if worker has completed contracts count them
                $contract = Contract::where('worker_id', $id)->where('Process_status', 'تم الانتهاء')->get();
                if (!$contract->isEmpty()) {
                    $data['CompletedContracts'] = count($contract);
                }
                // count all contracts for worker
                $contract = Contract::where('worker_id', $id)->get();
                if (!$contract->isEmpty()) {
                    $data['CustomerNumbers'] = count($contract);
                }
                // if worker has rates
                if (!$rate->isEmpty()) {
                    $data['quality_rate'] = $rate[0]->quality_rate;
                    $data['time_rate'] = $rate[0]->avg_time_rate;
                    $data['price_rate'] = $rate[0]->avg_price_rate;
                    $data['rate'] = $rate[0]->avg_rate;
                }
                if($worker->portfolio){
                    foreach ($worker->portfolio as $portfolio) {
                        if (!file_exists($portfolio->work_image)) {
                            //return response()->json($data, 200);
                        } else {
                            $file = file_get_contents($portfolio->work_image);
                            $base64 = base64_encode($file);
                            $work_images[] = $base64;
                        }
                    }
                    if (!empty($work_images))
                        $data['Portfolio'] = $work_images;
                }
                if ($worker->image) {
                    $path = public_path($worker->image);
                    if (!file_exists($path)) {
                        //return response()->json($data, 200);
                    } else {
                        $file = file_get_contents($path);
                        $base64 = base64_encode($file);
                        $data['image'] = $base64;
                        //return response()->json($data, 200);
                    }
                }
                return response()->json($data, 200);
            } else {
                return response()->json([
                    'message' => 'العامل غير موجود',
                    'status' => '401'
                ], 400);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'message' => 'حدث خطأ ما',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    // update function description
    public function updateDescription(Request $request, $id)
    {
        try {
            $request->validate([
                'description' => 'string|max:255',
            ]);
            $worker = Worker::find($id);
            if ($worker) {
                if ($request->description) {
                    $worker->description = $request->description;
                }
            }else{
                return response()->json([
                    'message' => 'Worker not found',
                ], 404);
            }
            $worker->save();
            if ($worker) {
                return response()->json([
                    'message' => 'تم تعديل البيانات بنجاح',

                ], 200);
            } else {
                return response()->json([
                    'message' => 'حدث خطأ ما',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'حدث خطأ ما',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    //store work images for worker
    public function storePortfolio(Request $request)
    {
        try {
            $request->validate([
                'work_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'worker_id' => 'required|integer',
            ]);
            $worker = Worker::find($request->worker_id);
            if ($worker) {
                $image = $request->file('work_image');
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                // Store the uploaded image in the public/images directory
                $path = $image->move('images', $filename);
                $portfolio = new Portfolio();
                $portfolio->work_image = $path;
                $portfolio->worker_id = $request->worker_id;
                $portfolio->save();
                if ($portfolio) {
                    return response()->json([
                        'message' => 'تم اضافة الصورة بنجاح',
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'حدث خطأ ما',
                    ], 401);
                }
            }else{
                return response()->json([
                    'message' => 'العامل غير موجود',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'حدث خطأ ما',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    //delete work one image for worker
    public function deletePortfolio($id)
    {
        try {
            $portfolio = Portfolio::find($id);
            if ($portfolio) {
                $portfolio->delete();
                return response()->json([
                    'message' => 'تم حذف الصورة بنجاح',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'حدث خطأ ما',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'حدث خطأ ما',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    //get all workers that there rate is greater than 4
    public function getBestWorkers()
    {
        try {
            $workers = DB::table('worker')
                ->join('category', 'worker.category_id', '=', 'category.id')
                ->join('rate', 'worker.id', '=', 'rate.worker_id')
                ->select(
                    'worker.id',
                    'worker.name',
                    'worker.email',
                    'worker.phone',
                    'worker.address',
                    'worker.image',
                    DB::raw('(SELECT name FROM category WHERE id = worker.category_id) as category_name'),
                    DB::raw('ROUND(AVG(quality_rate), 1) as quality_rate'),
                    DB::raw('ROUND(AVG(time_rate), 1) as avg_time_rate'),
                    DB::raw('ROUND(AVG(price_rate), 1) as avg_price_rate'),
                    DB::raw('ROUND((AVG(quality_rate) + AVG(time_rate) + AVG(price_rate)) / 3) as avg_rate')
                )
                ->groupBy('worker.id', 'worker.name', 'worker.email', 'worker.phone','worker.address','worker.image', 'worker.category_id')
                ->havingRaw('avg_rate >= 4')
                ->orderBy('worker.category_id')
                ->orderBy('avg_rate', 'desc')
                ->get();


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
            return response()->json([
                'success' => true,
                'best_workers' => $workers,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ ما',
                'error' => $th->getMessage(),
            ], 500);
        }
    }



}
