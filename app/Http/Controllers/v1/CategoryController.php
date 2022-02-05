<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\v1\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\JsonResponse;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @OA\Get (
     *   path="/api/v1/category",
     *   tags={"category"},
     *   summary="main",
     *     security={{"bearerAuth":{}}},
     *       description="main page ",
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *)
     * @return CategoryCollection
     */
    public function index(): CategoryCollection
    {
//        get and show all categories
        $category = Category::paginate(10);
        return new CategoryCollection($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post (
     *   path="/api/v1/category",
     *   tags={"category"},
     *   summary="main",
     *   security={{"bearerAuth":{}}},
     *   description="main page ",
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      description="edit category name",
     *      required=true,
     *    ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *)
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
//        create new category
        $category = Category::create($request->all());

        return response()->json([
            'product' => $category,
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @OA\Put (
     *   path="/api/v1/category/{id}",
     *   tags={"category"},
     *   summary="main",
     *   security={{"bearerAuth":{}}},
     *   description="main page ",
     *
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema (type = "string")
     *     ),
     *
     *    @OA\RequestBody (
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema (
     *                      @OA\Property (
     *                          property = "name",
     *                          type = "string"
     *                      )
     *              )
     *          )
     *     ),
     *
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",

     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *  ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *)
     * @param CategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
//        update category
        $category = $category->update($request->all());

        if ($category) {
            return response()->json([
                'category' => $category,
                'result' => 'category updated successfully',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'category' => $category,
                'result' => 'category updated was wrong',
                'status' => 'success'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Category $id): JsonResponse
    {
//        delete category
        Category::destroy($id);

        return response()->json([
            'result' => 'category deleted successfully',
            'status' => 'success'
        ]);
    }
}
