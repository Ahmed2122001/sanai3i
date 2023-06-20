<?php

namespace App\Http\Controllers\API\reports;

use App\Http\Controllers\Controller;
use App\Models\Report;
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
            $report=Report::orderBy('id','asc')->get();
            if ($report) {
                return response()->json([
                    'success'=>true,
                    'reports'=>$report,
                ],200);
            }else{
                return response()->json([
                    'success'=>false,
                ],400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>$th->getMessage(),
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
                'comment' => ['required','string', 'max:255'],
                'customer_id' => ['required', 'int'],
                'worker_id' => ['required', 'int'],
            ]);
            if ($validation->fails()) {
                return response()->json([
                    //'success'=>false,
                    'message' => $validation->errors()->all(),
                ], 400);
            } else {
                $report = Report::create($request->all());
                if ($report) {
                    return response()->json([
                        //'success'=>true,
                        'message' => 'report added',
                    ], 200);
                } else {
                    return response()->json([
                        //'success'=>true,
                        'message' => 'some problem',
                    ], 401);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                //'success'=>true,
                'message' => $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
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
        //
    }
}
