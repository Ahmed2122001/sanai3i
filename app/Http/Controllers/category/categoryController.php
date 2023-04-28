<?php

namespace App\Http\Controllers\category;

use Illuminate\Support\Facades\Storage;

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
        // Find the category by ID
        $category = Category::find($id);

        // If the category doesn't exist, return a 404 error response
        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        // Validate the request data
        $request->validate([
            'name' => 'string',
            'description' => 'string',
            'image' => 'file|mimes:jpeg,png|max:1024',
        ]);

        // Update the category attributes with the request data
        $category->name = $request->input('name');
        $category->description = $request->input('description');

        // If a new image has been uploaded, update the image path
        if ($request->hasFile('image')) {
            // Get the uploaded image file
            $uploadedFile = $request->file('image');

            // Generate a unique filename for the uploaded image
            $filename = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

            // Store the uploaded image in the public/images directory
            $path = $uploadedFile->storeAs('public/images', $filename);

            // Delete the old image file
            Storage::delete($category->image_path);

            // Update the category's image path with the new path
            $category->image_path = $path;
        }

        // Save the updated category to the database
        $category->save();

        // Return a response indicating that the category has been updated
        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category,
        ], 200);
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
