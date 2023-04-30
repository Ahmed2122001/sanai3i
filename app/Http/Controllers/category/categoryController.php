<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class categoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::get();
            return response()->json(['categories' => $categories, 'تم استرجاع البيانات بنجاح']);;
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
            if (!$category) {
                return response()->json([
                    'message' => 'لا يوجد بيانات'
                ], 404);
            } else
                return response()->json($category);
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
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|file|mimes:jpeg,png|max:1024',
            ]);

            // Get the uploaded image file
            $uploadedFile = $request->file('image');

            // Generate a unique filename for the uploaded image
            $filename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

            // Store the uploaded image in the public/images directory
            $path = $uploadedFile->storeAs('public/images', $filename);

            // Create a new category instance
            $category = new Category();
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->image = $path;
            $category->save();

            // Return a response indicating that the category has been created
            return response()->json([
                'message' => 'Category created successfully',
                // 'category' => $category,
            ], 201);
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
                'name' => 'string',
                'description' => 'string',
                'image' => 'file|mimes:jpeg,png|max:1024',
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
                // Update the category image, if a new one was uploaded
                if ($request->hasFile('image')) {
                    // Get the uploaded image file
                    $uploadedFile = $request->file('image');

                    // Generate a unique filename for the uploaded image
                    $filename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

                    // Store the uploaded image in the public/images directory
                    $path = $uploadedFile->storeAs('public/images', $filename);

                    // Delete the old image file
                    Storage::delete($category->image);

                    // Update the category image path
                    $category->image = $path;
                }
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
            if (!$category) {
                return response()->json([
                    'message' => 'Category not found'
                ], 404);
            }
            $category->delete();
            return response()->json([
                'message' => 'Category deleted',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Category not deleted',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
