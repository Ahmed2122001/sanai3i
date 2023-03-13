<?php

use App\Http\Controllers\API\admin\AdminController;
use App\Http\Controllers\API\customer\CustomerController;
use App\Http\Controllers\API\worker\WorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\categoryController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/categories', [categoryController::class, 'index']);
Route::get('/categories/{id}', [categoryController::class, 'show']);



Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth-customer'
    ],
    function ($router) {
        Route::post('/login', [AuthController::class, 'loginAsCustomer']);
        Route::post('/customer/register', [AuthController::class, 'customerRegister']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.gaurd:api-customer');
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    }
);
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth-worker'
    ],
    function ($router) {
        Route::post('/login', [AuthController::class, 'loginAsWorker']);
        Route::post('/worker/register', [AuthController::class, 'workerRegister']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.gaurd:api-worker');
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    }
);
Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth-admin'
    ],
    function ($router) {
        Route::post('/login', [AuthController::class, 'loginAsAdmin']);
    }
);
Route::group(
    [
        'middleware' => 'api',
        'middleware' => 'auth.gaurd:api-admin',
        'prefix' => 'auth-admin'
    ],
    function ($router) {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
        Route::post('/categories', [categoryController::class, 'create']);
        Route::put('/categories/{id}', [categoryController::class, 'update']);
        Route::delete('/categories/{id}', [categoryController::class, 'delete']);
        //admin
        Route::get('/admins', [AdminController::class, 'index']);
        Route::post('/', [AdminController::class, 'store']);
        //Route::get('/{admin}',[AdminController::class,'show']);
        Route::put('/{admin}', [AdminController::class, 'update']);
        Route::delete('/{admin}', [AdminController::class, 'delete']);
        //CATEGORIES
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        //Route::get('/{category}',[CategoryController::class,'show']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
        //
        //    //Route::get('/categories',[CategoryController::class,'index']);
        //
        //    //workers
        //    Route::get('/workers',[WorkerController::class,'index']);
        //    Route::post('/',[WorkerController::class,'store']);
        //    Route::get('/{worker}',[WorkerController::class,'show']);
        //    Route::put('/{worker}',[WorkerController::class,'update']);
        //    Route::delete('/{worker}',[WorkerController::class,'delete']);
        //
        //    //customers
        Route::get('/customers', [CustomerController::class, 'index']);

        //san3i
        //customer
        Route::get('/customers', [CustomerController::class, 'index']);
        Route::POST('/customers', [CustomerController::class, 'store']);
        //Route::get('/{customer}',[CustomerController::class,'show']);
        Route::PUT('/customers/{id}', [CustomerController::class, 'update']);
        Route::DELETE('/customers/{id}', [CustomerController::class, 'delete']);

    //customer
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::POST('/customers', [CustomerController::class, 'store']);
    //Route::get('/{customer}',[CustomerController::class,'show']);
    Route::PUT('/customers/{id}', [CustomerController::class, 'update']);
    Route::DELETE('/customers/{id}', [CustomerController::class, 'delete']);

    //workers
    Route::get('/workers', [WorkerController::class, 'index']);
    Route::post('/worker/store',[WorkerController::class,'store']);
    Route::get('/worker/show/{id}',[WorkerController::class,'show']);
    Route::post('/worker/update/{id}', [WorkerController::class, 'update']);
    Route::delete('/worker/delete/{id}', [WorkerController::class, 'delete']);
    
    }
);
