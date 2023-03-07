<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Worker;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /** 
     * Create a new AuthController instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'customerRegister', 'workerRegister']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only('email', 'password');
        $token = auth::guard('api-admin')->attempt($credentials);
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'بيانات الدخول غير صحيحه يرجلى ادخال البريد الاكتروني وكلمة سر صحيحه'], 401);
        }
        return $this->createNewToken($token);
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
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:11',
            'address' => 'required|string|between:4,100',
            'image' => 'string|between:100,250',
            'status' => 'string|between:5,10'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = Customer::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]

        ));
        $token = auth()->login($user);
        return response()->json([

            'message' => 'User successfully registered',
            'token' => $token,
            'user' => $user,

        ], 201);
    }
    public function workerRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:worker',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:11',
            'address' => 'required|string|between:4,100',
            'image' => 'string|between:100,250',
            'status' => 'string|between:5,10'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = Worker::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]

        ));
        $token = auth()->login($user);
        return response()->json([

            'message' => 'User successfully registered',
            'token' => $token,
            'user' => $user,

        ], 201);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
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
