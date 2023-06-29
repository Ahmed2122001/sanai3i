<?php

namespace App\Http\Controllers\API\rate;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function rateWorker(Request $request){
        try{
            $validate=$request->validate([
                'customer_id'=>'required',
                'worker_id'=>'required',
                'time_rate'=>'required|integer|between:1,5',
                'price_rate'=>'required|integer|between:1,5',
                'quality_rate'=>'required|integer|between:1,5',
                'contract_id'=>'required',

            ],[
                'rating.between' => 'The rating must be between 1 and 5.',
            ]);
//           dd($request);
            if (!$validate) {
                return response()->json($validate->errors(), 400);
            }
            $rate=new Rate;
            $rate->worker_id=$request->worker_id;
            $rate->time_rate=$request->time_rate;
            $rate->price_rate=$request->price_rate;
            $rate->quality_rate=$request->quality_rate;
            $rate->save();
            Contract::class->updateStatustoFinished($request->contract_id);
            return response()->json('تم تقييم العامل بنجاح',201);
        }catch (\Throwable $th){
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 404);
        }
    }
}
