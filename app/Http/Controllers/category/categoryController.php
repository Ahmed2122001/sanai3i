<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // $category = Category::find($id);
        // if (!$category) {
        //     return response()->json([
        //         'message' => 'Category not found'
        //     ], 404);
        // }
        // $validator = Validator::make($request->all(), [
        //     'name' => 'string|min:3|max:255| unique:category',
        //     'description' => 'string| min:3|max:255',
        //     'image' => 'String|min:3|max:255',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'Validation error',
        //         'errors' => $validator->errors()->all()
        //     ], 422);
        // }
        // $category->update($request->all());

        // return response()->json(["Category updated"], 200);


        // Validate the request data
        $request->validate([
            'name' => 'string',
            'description' => 'string',
            'image' => 'file|mimes:jpeg,png|max:1024',
        ]);

        // Find the category to update
        $category = Category::findOrFail($id);

        // Update the category name and description
        $category->name = $request->input('name');
        $category->description = $request->input('description');


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

        // Return a response indicating that the category has been updated
        return response()->json([
            'message' => 'Category updated successfully',

            // 'category' => $category,
        ]);
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
