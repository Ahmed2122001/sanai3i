<?php

namespace App\Http\Controllers\API\customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\customer\Throwable;
use App\Http\Requests\customer\StoreCustomerRequest;
use App\Http\Resources\customer\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $customer = Customer::orderBy('id', 'asc')->get();
            //$customer=CustomerResource::collection(Customer::all());
            if ($customer) {
                return response()->json([
                    //'success'=>true,
                    'customers' => $customer,
                ], 200);
            } else {
                return response()->json([
                    //'success'=>false,
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>false,
                'message' => $th->getMessage(),
            ], 400);
            //throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        try {
            $customer = Customer::create($request->all());
            if ($customer) {
                return response()->json([
                    //'success'=>true,
                    'message' => "Customer added",
                ], 200);
            } else {
                return response()->json([
                    //'success'=>true,
                    'message' => 'some problem',
                ], 401);
            }
            //            }
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
        try {
            //$customer=Customer::orderBy('id','asc')->get();
            $customer = Customer::find($id);

            if ($customer) {
                return response()->json([
                    //'success'=>true,
                    'customers' => $customer,
                ], 200);
            } else {
                return response()->json([
                    //'success'=>false,
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>false,
                'message' => $th->getMessage(),
            ], 400);
            //throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCustomerRequest $request, $id): JsonResponse
    {
        try {
            $request->validated();
            //$customers=Customer::findOrFail($id);
            $customers = Customer::where('id', $id)->first();
            //            $validation=Validator::make($request->all(),[
            //                'name'=>['string','max:255'],
            //                'email'=>'required|string|max:255|email|unique:customer,email,'.$request->id,
            //                'password'=>['string','min:5'],
            //                'phone'=>['int'],
            //                'address'=>['string'],
            //                'image'=>['string'],
            //            ]);
            //            if ($validation->fails()){
            //                return response()->json([
            //                    //'success'=>false,
            //                    'message'=>$validation->errors()->all(),
            //                ],400);
            //            }else{
            //
            //            }
            //$customers->update($request->all());
            if (!empty($request->name)) {
                $customers->name = $request->name;
            } else {
                $customers->name = $customers->name;
            }
            if (!empty($request->email)) {
                $customers->email = $request->email;
            } else {
                $customers->email = $customers->email;
            }
            if (!empty($request->password)) {
                $customers->password = $request->password;
            } else {
                $customers->password = $customers->password;
            }
            if (!empty($request->address)) {
                $customers->address = $request->address;
            } else {
                $customers->address = $customers->address;
            }
            if (!empty($request->image)) {
                $customers->image = $request->image;
            } else {
                $customers->image = $customers->image;
            }
            $result = $customers->save();
            if ($result) {
                return response()->json([
                    //'success'=>true,
                    'message' => $customers,
                ], 200);
            } else {
                return response()->json([
                    //'success'=>true,
                    'message' => 'some problem',
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>false,
                'message' => $th->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id): JsonResponse
    {
        try {
            $customer = Customer::findOrFail($id)->delete();
            if ($customer) {
                return response()->json([
                    'success' => true,
                    'message' => 'customer deleted successfully',
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'some problems',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
    /**
     * Customer profile
     */
    public function myprofile($id){
        try {
            $customer=Customer::where('id', $id)->with('region')->first();
            if ($customer){
                $region = [
                    'id' => $customer->region->id,
                    'city_name' => $customer->region->city_name,
                ];
                $data = [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'created_at' => $customer->created_at,
                    'Region' => $region,
                ];
                if ($customer->image) {
                    $path = public_path($customer->image);
                    if (!file_exists($path)) {
                        //return response()->json($data, 200);
                    } else {
                        $file = file_get_contents($path);
                        $base64 = base64_encode($file);
                        $data['image'] = $base64;
                        //return response()->json($data, 200);
                    }
                return response()->json([
                    'customer'=>$data
                ],200);
                }
            }else {
                return response()->json([
                    'message'=>'Customer not found'
                ],400);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
    public function update_porofile(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'string|max:255',
                'phone' => 'string|max:11|min:11',
                'address' => 'string|between:4,100',
                'city_id' => 'exists:region,id',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $customer = Customer::find($id);
            if ($customer) {
                if ($request->hasFile('image')) {
                    // Get the uploaded image file
                    $uploadedFile = $request->file('image');

                    // Generate a unique filename for the uploaded image
                    $filename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

                    // Store the uploaded image in the public/images directory
                    $path = $uploadedFile->move('images', $filename);

                    // Delete the old image file
                    Storage::delete($customer->image);

                    // Update the category image path
                    $customer->image = $path;
                }
                if ($request->name) {
                    $customer->name = $request->name;
                }
                if ($request->phone) {
                    $customer->phone = $request->phone;
                }
                if ($request->address) {
                    $customer->address = $request->address;
                }
                if ($request->city_id) {
                    $customer->city_id = $request->city_id;
                }
            }else{
                return response()->json([
                    'message' => 'Worker not found',
                ], 404);
            }
            $customer->save();
            if ($customer) {
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
                'message' => 'customer not updated',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
