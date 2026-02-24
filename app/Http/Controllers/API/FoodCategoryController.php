<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FoodCategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(): JsonResponse
    {
        $categories = FoodCategory::withCount('foods')->orderBy('id', 'desc')->get();

        return response()->json([
            'data' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:foods_categories,name',
            'description' => 'required|string|max:1000',
        ], [
            'name.required' => 'Category name is required.',
            'name.unique' => 'This category name already exists.',
            'description.required' => 'Description is required.',
        ]);

        $category = FoodCategory::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => new CategoryResource($category)
        ], 201);
    }

    /**
     * Display the specified category.
     */
    public function show(FoodCategory $category): JsonResponse
    {
        return response()->json([
            'data' => new CategoryResource($category->load('foods'))
        ]);
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, FoodCategory $category): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:foods_categories,name,' . $category->id,
            'description' => 'sometimes|string|max:1000',
        ], [
            'name.unique' => 'This category name already exists.',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => new CategoryResource($category->fresh())
        ]);
    }

    /**
     * Remove the specified category.
     */
    public function destroy(FoodCategory $category): JsonResponse
    {
        // Check if category has associated foods
        if ($category->foods()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete category with associated foods.'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
