<?php

use App\Http\Controllers\API\admin\AdminController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\category\CategoryController;
use App\Http\Controllers\Api\charts\ChartsController;
use App\Http\Controllers\Api\Contract\ContractController;
use App\Http\Controllers\API\filteration\filterController;
use App\Http\Controllers\API\payment\StripePaymentController;
use App\Http\Controllers\API\rate\RateController;
use App\Http\Controllers\API\region\RegionController;
use App\Http\Controllers\API\verifications\VerificationController;
use App\Http\Controllers\API\worker\WorkerController;
use App\Http\Controllers\API\reports\ReportController;
use App\Http\Controllers\API\customer\CustomerController;
use App\Http\Controllers\API\requests\RequestsController;
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
            Route::post('/notify', [AdminController::class, 'notifyWorkers']);

            //functionality
            Route::get('/fix/{id}', [AdminController::class, 'fixAccount']);
            Route::delete('/allusers/deletecustomer/{id}', [CustomerController::class, 'delete']);
            Route::put('/allusers/suspendcustomer/{id}', [AdminController::class, 'suspendCustomer']);
            Route::put('/allusers/activate/{id}', [AdminController::class, 'activateCustomer']);
            Route::delete('/allusers/deleteworker/{id}', [WorkerController::class, 'delete']);
            Route::put('/allusers/suspendworker/{id}', [AdminController::class, 'suspendWorker']);
            Route::put('/allusers/verifyworker/{id}', [AdminController::class, 'verifyWorker']);
            Route::get('/allusers', [AdminController::class, 'showAllAccounts']);
            Route::post('/category', [CategoryController::class, 'createCategory']);
            Route::post('/category/{id}', [CategoryController::class, 'update']);
            Route::delete('/categories/{id}', [CategoryController::class, 'delete']);
            Route::get('allcontracts',[ContractController::class,'index']);
            // get one category by id
            Route::get('/category/{id}', [CategoryController::class, 'show']);
            Route::get('/reports', [ReportController::class, 'index']);  //show all reports
            Route::get('report/{id}',[ReportController::class,'show']);
            Route::get('allusers/requestedworkers', [AdminController::class, 'showWorkersRequests']);
            Route::get('workersrates', [AdminController::class, 'showWorkersRates']);
            Route::get('getUsersByMonth', [ChartsController::class, 'getUsersByMonth']);
            Route::get('getRequestsByMonth', [ChartsController::class, 'getRequestsByMonth']);


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
            //Route::get('/user-profile', [AuthController::class, 'userProfile']);
            Route::get('/all-region', [RegionController::class, 'showAllRegions']);
            //myprofle
            Route::get('/profile/{id}',[CustomerController::class,'myprofile']);
            //filters
            Route::get('/category/{id}', [FilterController::class, 'filterByCategory']);
            Route::get('/region/{id}', [FilterController::class, 'filterByRegion']);
            //  Route::get('/category/{id}/region/{id}', [FilterController::class, 'filterByCategoryAndRegion']);
            // filter workers by category
            Route::get('/category/{id}', [filterController::class, 'filterByCategory']);
            // filter workers by region
            Route::get('/region/{id}', [filterController::class, 'filterByRegion']);
            // filter by category and region
            Route::post('/filterByCategoryAndRegion', [filterController::class, 'filterByCategoryAndRegion']);
            //  filterByPriceRateAndQualityRateAndTimeRate
            Route::post('/filterByPriceRateAndQualityRateAndTimeRate', [filterController::class, 'filterByPriceRateAndQualityRateAndTimeRate']);
            // filter by category and region and price rate and quality rate and time rate
            Route::post('filtration', [filterController::class, 'filter']);
            // payment route
            Route::post('/payment', [StripePaymentController::class, 'pay']);
            //rate worker
            Route::post('/rate', [RateController::class, 'rateWorker']);
            //show contracts
            Route::get('/showContracts/{id}', [ContractController::class, 'getMyContracts']);
            //add contract
            Route::post('/addContracts', [ContractController::class, 'store']);
            //delete contract
            Route::delete('/deleteContracts/{id}', [ContractController::class, 'destroy']);
            //accept contract
            Route::post('/acceptContract', [ContractController::class, 'customerAccept']);
            //reject contract
            Route::post('/rejectContracts/{id}', [ContractController::class, 'rejectContract']);
            //finish contract
            Route::post('/finishContracts/{id}', [ContractController::class, 'finishContract']);
            //report worker
            Route::post('/report', [ReportController::class, 'store']);
            Route::post('/makeRequest', [RequestsController::class, 'store']);
            Route::post('/update_profile/{id}', [CustomerController::class, 'update_porofile']);

        });
    }
);
//create route group for worker
Route::group(
    [
        'middleware' => 'auth.gaurd:api-worker',
        'prefix' => 'sanai3i'
    ],
    function ($router) {
        Route::prefix('worker')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/user-profile', [AuthController::class, 'userProfile']);
            Route::get('/all-region', [RegionController::class, 'showAllRegions']);
            Route::post('/password/{id}', [WorkerController::class, 'updatePassword']);
            Route::post('/update/{id}', [WorkerController::class, 'update']);
            Route::post('/update_profile/{id}', [WorkerController::class, 'update_porofile']);
            Route::get('/worker-profile/{id}', [WorkerController::class, 'showMyProfile']);
            Route::post('/description/{id}', [WorkerController::class, 'updateDescription']);

            // show all worker's contracts
            Route::get('/showContracts/{id}', [ContractController::class, 'getContracts']);
            Route::post('acceptContract', [ContractController::class, 'acceptContract']);
            Route::delete('deleteContracts/{id}', [ContractController::class, 'rejectContract']);
            //store worker's work
            Route::post('/storePortfolio', [WorkerController::class, 'storePortfolio']);
            //delete one image worker's work
            Route::delete('/deletePortfolio/{id}', [WorkerController::class, 'deletePortfolio']);
        });
    }
);
Route::prefix('sanai3i')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/all-region', [RegionController::class, 'showAllRegions']);
});

//for verification email
Route::get('email/verifyCustomer/{id}', [VerificationController::class, 'verifyCustomer'])->name('verification.verifyCustomer');
Route::get('email/verifyًWorker/{id}', [VerificationController::class, 'verifyًWorker'])->name('verification.verifyًWorker');
