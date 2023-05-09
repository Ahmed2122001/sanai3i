<?php

namespace App\Http\Controllers\API\worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\worker\WorkerReqest;
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
                    //                    'password'=>$request->password,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'image' => $request->image,
                    'description' => $request->description,
                    'portifolio' => $request->portifolio,
                ]);
                if ($worker) {
                    return response()->json([
                        //'success'=>true,
                        'message' => "your request added and admin will check it",
                    ], 200);
                } else {
                    return response()->json([
                        //'success'=>true,
                        'message' => 'some problem',
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
    public function update(WorkerReqest $request, $id): JsonResponse
    {
        $request->validated();
        $worker = Worker::where('id', $id)->first();
        //        $worker->update($request->all());
        if (!empty($request->name)) {
            $worker->name = $request->name;
        } else {
            $worker->name = $worker->name;
        }

        if (!empty($request->address)) {
            $worker->address = $request->address;
        } else {
            $worker->address = $worker->address;
        }
        if (!empty($request->image)) {
            $worker->image = $request->image;
        } else {
            $worker->image = $worker->image;
        }
        if (!empty($request->city_id)) {
            $worker->city_id = $request->city_id;
        } else {
            $worker->city_id = $worker->city_id;
        }
        if (!empty($request->filed_work)) {
            $worker->filed_work = $request->filed_work;
        } else {
            $worker->filed_work = $worker->filed_work;
        }
        if (!empty($request->description)) {
            $worker->description = $request->description;
        } else {
            $worker->description = $worker->description;
        }
        if (!empty($request->portifolio)) {
            $worker->portifolio = $request->portifolio;
        } else {
            $worker->portifolio = $worker->portifolio;
        }
        if (!empty($request->status)) {
            $worker->status = $request->status;
        } else {
            $worker->status = $worker->status;
        }
        if (!empty($request->role)) {
            $worker->role = $request->role;
        } else {
            $worker->role = $worker->role;
        }
        if (!empty($request->active_status)) {
            $worker->active_status = $request->active_status;
        } else {
            $worker->active_status = $worker->active_status;
        }
        if (!empty($request->messenger_color)) {
            $worker->messenger_color = $request->messenger_color;
        } else {
            $worker->messenger_color = $worker->messenger_color;
        }
        $result = $worker->save();
        if ($result) {
            return response()->json([
                //              'success'=>true,
                'message' => 'worker updated',
                'worker' => $worker
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
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $worker = Worker::where('id', $id)->first()->delete();
        if ($worker) {
            return response()->json([
                //              'success'=>true,
                'message' => 'worker deleted',
                'status' => '200'
            ], 200);
        } else {
            return response()->json([
                //                'success'=>false,
                'message' => 'worker not found',
                'status' => '401'
            ], 400);
        }
    }
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
                    Storage::delete($worker->image);

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
                'message' => 'Worker not updated',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    public function showMyProfile($id)
    {
        try{
            // get worker by id and his category and city and region and his rates and his portfolio
            $worker = Worker::where('id', $id)->with('category', 'region', 'rate', 'portfolio')->first();

            //dd($rate);
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
//                        DB::raw('AVG(quality_rate) as quality_rate'),
//                        DB::raw('AVG(time_rate) as avg_time_rate'),
//                        DB::raw('AVG(price_rate) as avg_price_rate'),
//                        DB::raw('(AVG(quality_rate) + AVG(time_rate) + AVG(price_rate)) / 3 as avg_rate'))
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
                    'Portfolio' => $worker->portfolio,
                    'Category' => $category,
                    'Region' => $region,
                ];
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
                    if ($rate) {
                        // add avg rate for 3 rates
                        $data['quality_rate'] = $rate[0]->quality_rate;
                        $data['time_rate'] = $rate[0]->avg_time_rate;
                        $data['price_rate'] = $rate[0]->avg_price_rate;
                        $data['rate'] = $rate[0]->avg_rate;
                        return response()->json($data, 200);
                    }else{
                        return response()->json($data, 200);
                    }
                } else {
                    return response()->json($data, 200);
                }

            } else {
                return response()->json([
                    'message' => 'worker not found',
                    'status' => '401'
                ], 400);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'message' => 'worker not found',
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
                'message' => 'Worker not updated',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
