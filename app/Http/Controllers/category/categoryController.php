<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return response()->json(['categories' => $categories, 'تم استرجاع البيانات بنجاح']);;
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
            'name' => 'string|min:3|max:255| unique:category',
            'description' => 'string| min:3|max:255',
            'image' => 'String|min:3|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()->all()
            ], 422);
        }
        $category->update($request->all());

        return response()->json(["Category updated"], 200);
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
