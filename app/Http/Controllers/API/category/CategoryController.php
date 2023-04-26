<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return response()->json(['region' => $categories, 'تم استرجاع البيانات بنجاح']);;
    }
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        } else
            return response()->json($category);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'max:255', 'unique:category'],
            'description' => ['min:3', 'max:255', 'nullable'],
            'image' => ['min:3', 'max:255', 'nullable'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()->all()
            ], 422);
        }
        $category = Category::create($request->all());
        if (!$category) {
            return response()->json([
                'message' => 'Category not created'
            ], 500);
        } else
            return response()->json($category);
    }
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'max:255', 'unique:category'],
            'description' => ['min:3', 'max:255', 'nullable'],
            'image' => ['min:3', 'max:255', 'nullable'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()->all()
            ], 422);
        }
        $category->update($request->all());
        return response()->json($category);
    }
    public function delete($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
        $category->delete();
        return response()->json([
            'message' => 'Category deleted'
        ]);
    }
}
