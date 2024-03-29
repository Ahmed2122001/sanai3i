<?php

namespace App\Http\Controllers\API\reports;

use App\Http\Controllers\Controller;
use App\Models\Report;
use http\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():JsonResponse
    {
        try {
            $report = Report::orderBy('id', 'asc')
                ->leftJoin('customer', 'report.customer_id', '=', 'customer.id')
                ->leftJoin('worker', 'report.worker_id', '=', 'worker.id')
                ->select(
                    'report.id',
                    'report.comment',
                    'report.created_at',
                    'report.updated_at',
                    'report.customer_id',
                    'report.worker_id',
                    'report.contract_id',
                    'customer.name as customer_name',
                    'worker.name as worker_name',
                    'customer.status as customer_status',
                    'worker.status as worker_status',
                )
                ->get();
//            dd($report);
            if ($report) {
                return response()->json([
                    'message'=>"تم استرجاع البلاغات بنجاح",
                    'reports'=>$report,
                ],200);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>"لا يوجد بلاغات",
                ],400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>"حدث خطأ ما",
                'error'=>$th->getMessage(),
            ],400);
            //throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'contract_id' => 'required|exists:contracts,id',
                'customer_id' => 'required|exists:customer,id',
                'worker_id' => 'required|exists:worker,id',
                'comment' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'message' => $validation->errors(),
                ], 400);
            }else{
                $report = new Report();
                $report->contract_id = $request->contract_id;
                $report->customer_id = $request->customer_id;
                $report->worker_id = $request->worker_id;
                $report->comment = $request->comment;
                $report->save();
                return response()->json([
                    'message'=>"تم تسجيل البلاغ بنجاح",
                    'report'=>$report,
                ],200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message'=>"حدث خطأ أثناء تسجيل الطلب",
                'error'=>$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show($id):jsonresponse
    {
        try {
            $report = Report::find($id);
             if ($report) {
                 return response()->json([
                     'success' => true,
                     'message' => "تم استرجاع البلاغ بنجاح",
                     'report' => $report,
                 ], 200);
             } else {
                 return response()->json([
                     'success' => false,
                     'message' => "لا يوجد بلاغات",
                 ], 400);
             }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>false,
                'message' => $th->getMessage(),
                'report' => 'حدث خطأ ما',
            ], 400);
            //throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {

    }
}
