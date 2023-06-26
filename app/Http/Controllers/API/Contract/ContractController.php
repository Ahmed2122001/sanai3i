<?php

namespace App\Http\Controllers\Api\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Worker;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ContractController extends Controller
{
    // show contracts
    public function index(){
        try {
            $contracts = Contract::all();
            if($contracts){
                return response()->json([
                    'success' => 'success',
                    'contracts'=>$contracts,
                ], 200);
            }



        }catch (\Throwable $th) {
                return response()->json([
                    'success' => 'error',
                    'message' => $th->getMessage(),
                ], 404);
        }
    }
    // store function
    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                //'price' => 'required',
                'start_date' => 'required',
                'ex_end_date' => 'required',
                'customer_id' => 'required',
                'worker_id' => 'required',
                'discrption' => 'required',
            ]);
            if (!$validate) {
                return response()->json($validate->errors(), 400);
            }
            $startDate = Carbon::createFromFormat('Y-m-d', $validate['start_date']);
            $exEndDate = Carbon::createFromFormat('Y-m-d', $validate['ex_end_date']);
            $contract = new Contract;
            // set the price as initial_price of worker
            $price = Worker::findOrFail($request->worker_id)->only('initial_price');
            $contract->price =$price['initial_price'] ;
            $contract->start_date = $startDate;
            $contract->ex_end_date = $exEndDate;
            $contract->discrption = $request->discrption;
            $contract->customer_id = $request->customer_id;
            $contract->worker_id = $request->worker_id;
            $contract->save();
            return response()->json('تم اضافة العقد بنجاح', 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }

    }
    //delete contract
    public function destroy($id){
        try {
            $contract=Contract::findOrFail($id);
            $contract->Process_status="ملغي";
            $contract->save();
            if($contract){
                return response()->json([
                   'success'=>'success',
                    'message'=>'تم حذف العقد بنجاح'
                ],200);
            }else {
                return response()->json([
                    'success' => 'failed',
                    'message' => 'لم يتم حذف العقد بنجاح حاول مره اخرى'
                ], 400);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'success' => 'error',
                'message' => $th->getMessage(),
            ], 404);
        }
    }
    // get my contracts by customer id
    public function getMyContracts($id){
        try {
            $contracts = Contract::where('customer_id', $id)
                ->leftJoin('worker', 'contracts.worker_id', '=', 'worker.id')
                ->leftJoin('category', 'worker.category_id', '=', 'category.id')
                ->select('contracts.*', 'worker.name', 'worker.email', 'worker.address', 'worker.phone', 'category.name as category_name')
                ->get();
            if($contracts){
                return response()->json([
                    'success'=>true,
                    'contracts'=>$contracts,
                ],200);
            }else {
                return response()->json([
                    'success' => 'failed',
                    'message' => 'لم يتم العثور على العقود'
                ], 400);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'success' => 'error',
                'message' => $th->getMessage(),
            ], 404);
        }
    }
    // get my contracts by worker id
    public function getContracts($id){
        try {
            $contracts=Contract::where('worker_id',$id)->with('worker','customer')->get();
            if ($contracts){
                return response()->json([
                    'success'=>true,
                    'contracts'=>$contracts
                ],200);
            }else{
                return response()->json([
                    'success' => 'failed',
                    'message' => 'لم يتم العثور على العقود'
                ],400);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'success' => 'error',
                'message' => $th->getMessage(),
            ], 404);
        }
    }
    //accept contract
    public function acceptContract(Request $request,$id){
        try {
            $contract=Contract::findOrFail($id);
            if($contract){
                $validate = $request->validate([
                    'price' => 'required',
                ]);
                if (!$validate) {
                    return response()->json($validate->errors(), 400);
                }
                $contract->status=1;
                $contract->Process_status="تم تحديد السعر من قبل العامل";
                $contract->price=$request->price;
                $contract->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'تم قبول العقد بنجاح'
                ],200);
            }else{
                return response()->json([
                    'success' => 'failed',
                    'message' => 'لم يتم العثور على العقد'
                ],400);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'success' => 'error',
                'message' => $th->getMessage(),
            ], 404);
        }
    }
    //reject contract
    public function rejectContract($id){
        try {
            $contract=Contract::findOrFail($id);
            if($contract){
                $contract->status=0;
                $contract->Process_status="ملغي";
                $contract->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'تم رفض العقد بنجاح'
                ],200);
            }else{
                return response()->json([
                    'success' => 'failed',
                    'message' => 'لم يتم العثور على العقد'
                ],400);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'success' => 'error',
                'message' => $th->getMessage(),
            ], 404);
        }
    }
    //finish contract
    public function finishContract($id){
        try {
            // set contract process_status to تم الانتهاء
            $contract=Contract::findOrFail($id);
            if($contract){
                $contract->Process_status="تم الانتهاء";
                $contract->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'تم انهاء العقد بنجاح',
                    'contract'=>$contract
                ],200);
            }else{
                return response()->json([
                    'success' => 'failed',
                    'message' => 'لم يتم العثور على العقد'
                ],400);
            }
        }catch (\Throwable $th) {
         return response()->json([
             'success' => 'error',
             'message' => $th->getMessage(),
         ], 404);
        }
    }
    public function customerAccept($id){
        try {
            $contract=Contract::findOrFail($id);
            if($contract){
                $contract->Process_status="جاري العمل عليه";
                $contract->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'تم قبول العقد بنجاح',
                    'contract'=>$contract
                ],200);
            }else{
                return response()->json([
                    'success' => 'failed',
                    'message' => 'لم يتم العثور على العقد'
                ],400);
            }
        }catch (\Throwable $th) {
         return response()->json([
             'success' => 'error',
             'message' => $th->getMessage(),
         ], 404);
        }
    }
}
