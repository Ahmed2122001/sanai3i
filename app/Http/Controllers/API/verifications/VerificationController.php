<?php

namespace App\Http\Controllers\API\verifications;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Worker;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifyCustomer($user_id, Request $request){
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'رابط غير صالح / منتهي الصلاحية.'
            ], 401);
        }
        $user = Customer::findOrFail($user_id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }else{
            return response()->json([
                'message' => 'تم التحقق من البريد الالكتروني بالفعل'
            ], 422);
        }

//        $token = auth()->login($user);
        return response()->json([
            'message' => " تم التحقق من البريد الالكتروني بنجاح",
//            'token' => $token,
        ], 200);

    }
    public function verifyًWorker($user_id, Request $request){
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'رابط غير صالح / منتهي الصلاحية.'
            ], 401);
        }
        $user = Worker::findOrFail($user_id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }else{
            return response()->json([
                'message' => 'تم التحقق من البريد الالكتروني بالفعل'
            ], 422);
        }

//        $token = auth()->login($user);
        return response()->json([
            'message' => " تم التحقق من البريد الالكتروني بنجاح",
//            'token' => $token,
        ], 200);

    }
}
