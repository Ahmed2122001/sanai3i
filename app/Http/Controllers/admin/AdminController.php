<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $admin=Admin::orderBy('id','asc')->get();
            if ($admin) {
                return response()->json([
                    'success'=>true,
                    'admins'=>$admin,
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
     */
    public function store(Request $request): JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin): JsonResponse
    {
        //
    }
    public function delete($id) :JsonResponse
    {
        try {
            $admin=Admin::findOrFail($id)->delete();
            if ($admin) {
                return response()->json([
                    'success'=>true,
                    'message'=>'admin deleted successfully',
                ]);
            } else {
                return response()->json([
                    'success'=>true,
                    'message'=>'some problems',
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'success'=>false,
                'message'=>$th->getMessage(),
            ]);
        }

    }
}
