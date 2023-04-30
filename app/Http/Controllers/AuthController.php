<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Worker;
use App\Models\Region;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Traits\GeneralTrait;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Container\CircularDependencyException;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use PhpParser\Node\Stmt\If_;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     * @return void
     */
    use GeneralTrait;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['loginAsAdmin', 'loginAsWorker', 'loginAsCustomer', 'customerRegister', 'workerRegister', 'logout']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginAsAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');
        $token = auth::guard('api-admin')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'بيانات الدخول غير صحيحه يرجلى ادخال البريد الاكتروني او كلمة سر صحيحه'], 401);
        } else {
            $admin = auth::guard('api-admin')->user();
            $admin->remembertoken = $token;
            return $this->returnData('remember_token', $token, 'تم تسجيل الدخول بنجاح');
        }
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function customerRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:customer',
            'password' => 'required|string|max:8|min:8',
            'phone' => 'required|string|max:11|min:11',
            'address' => 'required|string|between:4,100',
            'city_id ' => 'exists:region,id',
            'image' => 'string|between:100,250',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $region = Region::find($request->input('city_id'));
        if (!$region) {
            return $this->returnError('404', 'هذه المدينه غير موجوده');
        }
        $user = new Customer();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->city_id = $region->id;
        $user->image = $request->input('image');
        $user->save();


        // $user->notify(new VerifyEmail);
        $token = auth()->login($user);
        return response()->json([

            'message' => 'تم تسجيل الدخول بنجاح',
            'remember_token' => $token,
            // 'user' => $user,

        ], 201);
    }
    public function getcitybyid($id)
    {
        $city = Region::find($id);
        if (!$city) {
            return $this->returnError('404', 'هذه المدينه غير موجوده');
        }
        return $this->returnData('city', $city['name'], 'تم استرجاع المدينه بنجاح');
    }
    public function workerRegister(Request $request)
    {
        // $city_id = Region::select('id')->where('city_name', $request->city)->first();
//         dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:worker',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:11|min:11',
            'address' => 'required|string|between:4,100',
            'city_id ' => 'exists:region,id',
            'category_id ' => 'exists:category,id',
            'description' => 'string|between:50,500',
            'image' => 'string|between:100,250',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $Category = Category::find($request->input('category_id'));
        $region = Region::find($request->input('city_id'));
        if (!$region) {
            return $this->returnError('404', 'هذه المدينه غير موجوده');
        }
        if (!$Category) {
            return $this->returnError('404', 'هذه الفئه غير موجوده');
        }
        $user = new Worker();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->city_id = $region->id;
        $user->category_id = $Category->id;
        $user->description = $request->input('description');
        $user->image = $request->input('image');
        $user->save();
        $token = auth()->login($user);
        return response()->json([

            'message' => 'تم تسجيل الدخول بنجاح',
            'remember_token' => $token,
            // 'user' => $user,

        ], 201);
    }
    public function loginAsWorker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');
        $token = auth::guard('api-worker')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'بيانات الدخول غير صحيحه يرجى ادخال البريد الاكتروني او كلمة سر صحيحه'], 401);
        } else {
            $worker = auth::guard('api-worker')->user();
            $worker->remembertoken = $token;
            return $this->returnData('remember_token', $token, 'تم تسجيل الدخول بنجاح');
        }
    }
    public function loginAsCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');
        $token = auth::guard('api-customer')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'بيانات الدخول غير صحيحه يرجى ادخال البريد الاكتروني او كلمة سر صحيحه'], 401);
        } else {
            $customer = auth::guard('api-customer')->user();
            $customer->remembertoken = $token;
            return $this->returnData('remember_token', $token, 'تم تسجيل الدخول بنجاح');
        }
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->header('remember_token');
        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
                return $this->returnSuccessMessage('تم تسجيل الخروج بنجاح');
            } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->returnError('E001', 'something went wrong');
            }
        }
    }



    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
