<?php

use App\Http\Controllers\API\admin\AdminController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\categoryController;
use App\Http\Controllers\API\customer\CustomerController;
use App\Http\Controllers\API\worker\WorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::get('/categories', [categoryController::class, 'index']);
//Route::get('/categories/{id}', [categoryController::class, 'show']);
//Route::post('/categories', [categoryController::class, 'create']);
//Route::put('/categories/{id}', [categoryController::class, 'update']);
//Route::delete('/categories/{id}', [categoryController::class, 'delete']);
//
//
//Route::group(
//    [
//        'middleware' => 'api',
//        'prefix' => 'auth'
//    ],
//    function ($router) {
//        Route::post('/login', [AuthController::class, 'login']);
//        Route::post('/register', [AuthController::class, 'register']);
//        Route::post('/logout', [AuthController::class, 'logout']);
//        Route::post('/refresh', [AuthController::class, 'refresh']);
//        Route::get('/user-profile', [AuthController::class, 'userProfile']);
//    }
//);
Route::prefix('/admin')->group(function (){

    //admin
    Route::get('/admins',[AdminController::class,'index']);
    Route::post('/',[AdminController::class,'store']);
    Route::put('/{admin}',[AdminController::class,'update']);
    Route::delete('/{admin}',[AdminController::class,'delete']);

    //fuctionality
    Route::get('/fix/{id}',[AdminController::class,'fixAccount']);
    Route::delete('/allusers/deletecustomer/{id}',[AdminController::class,'deleteCustomer']);
    Route::put('/allusers/suspendcustomer/{id}',[AdminController::class,'suspendCustomer']);
    Route::put('/allusers/activate/{id}',[AdminController::class,'activateCustomer']);
    Route::delete('/allusers/deleteworker/{id}',[AdminController::class,'deleteWorker']);
    Route::put('/allusers/suspendworker/{id}',[AdminController::class,'suspendWorker']);
    Route::put('/allusers/verifyworker/{id}',[AdminController::class,'verifyWorker']);
    Route::get('/allusers',[AdminController::class,'showAllAccounts']);
    Route::post('/category',[AdminController::class,'createCategory']);



//
//    //Route::get('/categories',[CategoryController::class,'index']);
//
//    //workers
    Route::get('/workers',[WorkerController::class,'index']);


//    //customers
    Route::get('/customers',[CustomerController::class,'index']);


    //reports
    Route::get('/reports',[AdminController::class,'showReports']);

});
Route::prefix('sani3i')->group(function (){

    //customer
    Route::get('/customers',[CustomerController::class,'index']);
    Route::POST('/customers',[CustomerController::class,'store']);
    //Route::get('/{customer}',[CustomerController::class,'show']);
    Route::PUT('/customers/{id}',[CustomerController::class,'update']);
    Route::DELETE('/customers/{id}',[CustomerController::class,'delete']);

    //workers
    Route::get('/workers',[WorkerController::class,'index']);
    Route::post('/workers',[WorkerController::class,'store']);
    //Route::get('/workers/{id}',[WorkerController::class,'show']);
    Route::put('/worker/{id}',[WorkerController::class,'update']);
    Route::delete('/workers/{id}',[WorkerController::class,'delete']);
});
