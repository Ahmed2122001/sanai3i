<?php

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
Route::post('/categories', [categoryController::class, 'create']);
Route::put('/categories/{id}', [categoryController::class, 'update']);
Route::delete('/categories/{id}', [categoryController::class, 'delete']);


Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth-customer'
    ],
    function ($router) {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/customer/register', [AuthController::class, 'customerRegister']);
        Route::post('/logout', [AuthController::class, 'logout']);
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
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/worker/register', [AuthController::class, 'workerRegister']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    }
);
Route::prefix('/admin')->group(function () {

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
    //    Route::POST('/',[CustomerController::class,'store']);
    //    Route::get('/{customer}',[CustomerController::class,'show']);
    //    Route::PUT('/{customer}',[CustomerController::class,'update']);
    //    Route::DELETE('/{customer}',[CustomerController::class,'delete']);

});
Route::prefix('sani3i')->group(function () {

    //customer
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::POST('/customers', [CustomerController::class, 'store']);
    //Route::get('/{customer}',[CustomerController::class,'show']);
    Route::PUT('/customers/{id}', [CustomerController::class, 'update']);
    Route::DELETE('/customers/{id}', [CustomerController::class, 'delete']);

    //workers
    Route::get('/workers', [WorkerController::class, 'index']);
    //Route::post('/workers',[WorkerController::class,'store']);
    //Route::get('/workers/{id}',[WorkerController::class,'show']);
    Route::put('/worker/{id}', [WorkerController::class, 'update']);
    Route::delete('/workers/{id}', [WorkerController::class, 'delete']);
});
