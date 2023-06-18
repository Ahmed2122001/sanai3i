<?php

namespace App\Http\Controllers\Api\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract;
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
                ], 201);
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
                'price' => 'required',
                'start_date' => 'required',
                'ex_end_date' => 'required',
                'customer_id' => 'required',
                'worker_id' => 'required',
            ]);
            if (!$validate) {
                return response()->json($validate->errors(), 400);
            }
            $startDate = Carbon::createFromFormat('Y-m-d', $validate['start_date']);
            $exEndDate = Carbon::createFromFormat('Y-m-d', $validate['ex_end_date']);
            $contract = new Contract;
            $contract->price = $request->price;
            $contract->start_date = $startDate;
            $contract->ex_end_date = $exEndDate;
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
            $contract=Contract::findOrFail($id)->delete();
            if($contract){
                return response()->json([
                   'success'=>'success',
                    'message'=>'تم حذف العقد بنجتح'

                ],201);
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




}