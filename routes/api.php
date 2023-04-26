<?php

use App\Http\Controllers\API\admin\AdminController;
use App\Http\Controllers\API\customer\CustomerController;
use App\Http\Controllers\API\worker\WorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\category\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\region\RegionController;
use App\Http\Controllers\filterController;

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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth-customer'
    ],
    function ($router) {
        Route::post('/login', [AuthController::class, 'loginAsCustomer']);
        Route::post('/customer/register', [AuthController::class, 'customerRegister']);
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
        'middleware' => 'auth.gaurd:api-admin',
        'prefix' => 'sanai3i'
    ],
    function ($router) {
        //admin
        Route::prefix('/admin')->group(function () {
            //admin
            Route::get('/admins', [AdminController::class, 'index']);
            Route::post('/addadmins', [AdminController::class, 'addAdmin']);
            Route::put('/{admin}', [AdminController::class, 'update']);
            Route::delete('/{admin}', [AdminController::class, 'delete']);
            Route::post('/logout', [AuthController::class, 'logout']);

            //functionality
            Route::get('/fix/{id}', [AdminController::class, 'fixAccount']);
            Route::delete('/allusers/deletecustomer/{id}', [AdminController::class, 'deleteCustomer']);
            Route::put('/allusers/suspendcustomer/{id}', [AdminController::class, 'suspendCustomer']);
            Route::put('/allusers/activate/{id}', [AdminController::class, 'activateCustomer']);
            Route::delete('/allusers/deleteworker/{id}', [AdminController::class, 'deleteWorker']);
            Route::put('/allusers/suspendworker/{id}', [AdminController::class, 'suspendWorker']);
            Route::put('/allusers/verifyworker/{id}', [AdminController::class, 'verifyWorker']);
            Route::get('/allusers', [AdminController::class, 'showAllAccounts']);
            Route::post('/category', [AdminController::class, 'createCategory']);
            Route::put('/{category}', [CategoryController::class, 'update']);
            Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
            Route::get('/reports', [AdminController::class, 'showReports']);  //show all reports
        });
        Route::prefix('region')->group(function () {
            //regions
            // Route::get('/all-region', [RegionController::class, 'showAllRegions']);
            Route::post('/store', [RegionController::class, 'create']);
            Route::get('/show/{id}', [RegionController::class, 'showOneRegion']);
            // Route::put('/update/{id}', [RegionController::class, 'update']);
            Route::delete('/delete/{id}', [RegionController::class, 'delete']);
        });
    }
);


//create route group for customer
Route::group(
    [
        'middleware' => 'auth.gaurd:api-customer',
        'prefix' => 'sanai3i'
    ],
    function ($router) {
        Route::prefix("customer")->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/user-profile', [AuthController::class, 'userProfile']);
            Route::get('/all-region', [RegionController::class, 'showAllRegions']);
            //filters
            Route::get('/category/{id}', [FilterController::class, 'filterByCategory']);
            Route::get('/region/{id}', [FilterController::class, 'filterByRegion']);
            //  Route::get('/category/{id}/region/{id}', [FilterController::class, 'filterByCategoryAndRegion']);
            // filter by category
            Route::get('/category/{id}', [filterController::class, 'filterByCategory']);
            // filter by region
            Route::get('/region/{id}', [filterController::class, 'filterByRegion']);
            // filter by category and region
            Route::post('/filterByCategoryAndRegion', [filterController::class, 'filterByCategoryAndRegion']);
            //  filterByPriceRateAndQualityRateAndTimeRate
            Route::post('/filterByPriceRateAndQualityRateAndTimeRate', [filterController::class, 'filterByPriceRateAndQualityRateAndTimeRate']);
            // filter by category and region and price rate and quality rate and time rate
            Route::post('filtration', [filterController::class, 'filter']);
        });
    }
);
//create route group for worker
Route::group(
    [
        'middleware' => 'auth.gaurd:api-worker',
        'prefix' => 'worker'
    ],
    function ($router) {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
        Route::get('/all-region', [RegionController::class, 'showAllRegions']);
        Route::post('/password/{id}', [WorkerController::class, 'updatePassword']);
        Route::post('/update/{id}', [WorkerController::class, 'update']);
    }
);
Route::prefix('sanai3i')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/all-region', [RegionController::class, 'showAllRegions']);
});
