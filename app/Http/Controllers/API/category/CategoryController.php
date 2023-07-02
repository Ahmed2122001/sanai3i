<?php

namespace App\Http\Controllers\API\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::get();
            return response()->json(['categories' => $categories, 'تم استرجاع البيانات بنجاح']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'لا يوجد بيانات',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
    public function show($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                return response()->json([
                    'category' => $category,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'لا يوجد بيانات',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'لا يوجد بيانات',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
    public function createCategory(Request $request)
    {
        try {
//            dd($request->all());


            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:category',
                'description' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

//            // Get the uploaded image file
//            $uploadedFile = $request->file('image');
//
//            // Generate a unique filename for the uploaded image
//            $filename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
//
//            // Store the uploaded image in the public/images directory
//            $path=$uploadedFile->move('images', $filename);
//            //dd($path);

//            $path = $uploadedFile->storeAs('public/images', $filename);

            // Create a new category instance
            $category =Category::create([
                'name' => $request->name,
                'description' => $request->description,
                //'image' => $path,
            ]);
            if ($category) {
                return response()->json([
                    'message' => 'تم اضافة القسم بنجاح',
                    'category' => $category,
                ], 201);
            } else {
                return response()->json([
                    'message' => 'لا يوجد بيانات',
                ], 404);
            }
        } catch (\Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => $throwable->getMessage(),
            ], 404);
        }
        // Validate the request data

    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'string|max:255|unique:category,name,' . $id,
                'description' => 'required|string|max:255',
                //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Find the category to update
            $category = Category::findOrFail($id);

            if ($category) {
                if ($request->has('name')) {
                    $category->name = $request->name;
                }
                if ($request->has('description')) {
                    $category->description = $request->description;
                }
//                // Update the category image, if a new one was uploaded
//                if ($request->hasFile('image')) {
//                    // Get the uploaded image file
//                    $uploadedFile = $request->file('image');
//
//                    // Generate a unique filename for the uploaded image
//                    $filename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
//
//                    // Store the uploaded image in the public/images directory
//                    $path = $uploadedFile->storeAs('public/images', $filename);
//
//                    // Delete the old image file
//                    Storage::delete($category->image);
//
//                    // Update the category image path
//                    $category->image = $path;
//                }
                // Save the updated category
                $category->save();
                if ($category) {
                    return response()->json([
                        'message' => 'Category updated successfully',
                        'category' => $category
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Category not updated',
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'Category not found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not updated',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function delete($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $del=$category->delete();
                if ($del) {
                    return response()->json([
                        'message' => 'Category deleted',
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Category not deleted',
                    ], 500);
                }
            }else{
                return response()->json([
                    'message' => 'Category not found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not deleted',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
