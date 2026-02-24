<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class FoodsController extends Controller
{
    /**
     * Display a listing of foods with pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $foods = Food::with('category')->orderBy('id', 'desc')->paginate($perPage);

        return response()->json([
            'data' => FoodResource::collection($foods),
            'meta' => [
                'current_page' => $foods->currentPage(),
                'last_page' => $foods->lastPage(),
                'per_page' => $foods->perPage(),
                'total' => $foods->total(),
            ]
        ]);
    }

    /**
     * Store a newly created food.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:foods_categories,id',
            'size' => 'required|string|in:Small,Medium,Large',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'stock_status' => 'required|string|in:in_stock,out_of_stock'
        ], [
            'name.required' => 'Food name is required.',
            'description.required' => 'Description is required.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'size.required' => 'Size is required.',
            'size.in' => 'Size must be Small, Medium, or Large.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'stock_status.required' => 'Stock status is required.',
            'stock_status.in' => 'Stock status must be in_stock or out_of_stock.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size cannot exceed 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $food = Food::create($validated);

        return response()->json([
            'message' => 'Food created successfully',
            'data' => new FoodResource($food->load('category'))
        ], 201);
    }

    /**
     * Display the specified food.
     */
    public function show(Food $food): JsonResponse
    {
        return response()->json([
            'data' => new FoodResource($food->load('category'))
        ]);
    }

    /**
     * Update the specified food.
     */
    public function update(Request $request, Food $food): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'category_id' => 'sometimes|exists:foods_categories,id',
            'size' => 'sometimes|string|in:Small,Medium,Large',
            'price' => 'sometimes|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'stock_status' => 'sometimes|string|in:in_stock,out_of_stock'
        ], [
            'category_id.exists' => 'Selected category does not exist.',
            'size.in' => 'Size must be Small, Medium, or Large.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
            'stock_status.in' => 'Stock status must be in_stock or out_of_stock.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size cannot exceed 2MB.',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($food->image) {
                Storage::disk('public')->delete($food->image);
            }
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($validated);

        return response()->json([
            'message' => 'Food updated successfully',
            'data' => new FoodResource($food->load('category'))
        ]);
    }

    /**
     * Remove the specified food.
     */
    public function destroy(Food $food): JsonResponse
    {
        // Delete image if exists
        if ($food->image) {
            Storage::disk('public')->delete($food->image);
        }

        $food->delete();

        return response()->json([
            'message' => 'Food deleted successfully'
        ]);
    }
}
