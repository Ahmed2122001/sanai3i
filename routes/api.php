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
//        'middleware' => 'api',
//        'middleware' => 'auth.gaurd:api-admin',
        'prefix' => 'sanai3i'
    ],
    function ($router) {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
        Route::post('/categories', [categoryController::class, 'create']);
        Route::put('/categories/{id}', [categoryController::class, 'update']);
        Route::delete('/categories/{id}', [categoryController::class, 'delete']);
        //admin
        Route::prefix('/admin')->group(function (){
            //admin
            Route::get('/admins',[AdminController::class,'index']);
            Route::post('/addadmins',[AdminController::class,'addAdmin']);
            Route::put('/{admin}',[AdminController::class,'update']);
            Route::delete('/{admin}',[AdminController::class,'delete']);
            //functionality
            Route::get('/fix/{id}',[AdminController::class,'fixAccount']);
            Route::delete('/allusers/deletecustomer/{id}',[AdminController::class,'deleteCustomer']);
            Route::put('/allusers/suspendcustomer/{id}',[AdminController::class,'suspendCustomer']);
            Route::put('/allusers/activate/{id}',[AdminController::class,'activateCustomer']);
            Route::delete('/allusers/deleteworker/{id}',[AdminController::class,'deleteWorker']);
            Route::put('/allusers/suspendworker/{id}',[AdminController::class,'suspendWorker']);
            Route::put('/allusers/verifyworker/{id}',[AdminController::class,'verifyWorker']);
            Route::get('/allusers',[AdminController::class,'showAllAccounts']);
            Route::post('/category',[AdminController::class,'createCategory']);
            Route::get('/reports',[AdminController::class,'showReports']);  //show all reports
        });

        //CATEGORIES
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        //Route::get('/{category}',[CategoryController::class,'show']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        Route::prefix('customer')->group(function (){

            //customer
            Route::get('/customers', [CustomerController::class, 'index']);
            Route::POST('/store', [CustomerController::class, 'store']);
            Route::GET('/show/{id}', [CustomerController::class, 'show']);
            Route::PUT('/update/{id}', [CustomerController::class, 'update']);
            Route::DELETE('/delete/{id}', [CustomerController::class, 'delete']);
        });


        Route::prefix('worker')->group(function (){
            //workers
            Route::get('/workers', [WorkerController::class, 'index']);
            Route::post('/store',[WorkerController::class,'store']);
            Route::get('/show/{id}',[WorkerController::class,'show']);
            Route::post('/update/{id}', [WorkerController::class, 'update']);
            Route::delete('/delete/{id}', [WorkerController::class, 'delete']);
        });
    }
);
