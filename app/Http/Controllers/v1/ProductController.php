<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\v1\ProductCollection;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get (
     *   path="/api/v1/product",
     *   tags={"product"},
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
     *
     * @return ProductCollection|Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
//        get and show all users
        $product = Product::withCount('likes' , 'comments')->paginate(3);

//        return $product;

        return new ProductCollection($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post (
     *   path="/api/v1/product",
     *   tags={"product"},
     *   summary="main",
     *   security={{"bearerAuth":{}}},
     *   description="main page ",
     *
     *
     *    @OA\RequestBody (
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema (
     *                      @OA\Property (
     *                          property = "title",
     *                          type = "string"
     *                      ),
     *                      @OA\Property (
     *                          property = "description",
     *                          type = "string"
     *                      ),
     *                      @OA\Property (
     *                          property = "img",
     *                          type = "file"
     *                      ),
     *                      @OA\Property (
     *                          property = "category_id",
     *                          type = "string"
     *                      ),
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
     *
     * @param ProductRequest $request
     */
    public function store(ProductRequest $request): \Illuminate\Http\JsonResponse
    {
//        create new product
        $product = $request->createProduct();

        if ($product) {
            return response()->json([
                'product' => $product,
                'result' => 'product added successfully',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'result' => 'product added was wrong',
                'status' => 'error'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put (
     *   path="/api/v1/product/{id}",
     *   tags={"product"},
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
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema (
     *                      @OA\Property (
     *                          property = "title",
     *                          type = "string"
     *                      ),
     *                      @OA\Property (
     *                          property = "description",
     *                          type = "string"
     *                      ),
     *                      @OA\Property (
     *                          property = "img",
     *                          type = "file"
     *                      ),
     *                      @OA\Property (
     *                          property = "category_id",
     *                          type = "string"
     *                      ),
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
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function update(ProductRequest $request, Product $product): \Illuminate\Http\JsonResponse
    {
//            update user
        $product = $request->updateProduct($product);

        if ($product) {
            return response()->json([
                'product' => $product,
                'result' => 'product updated successfully',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'result' => 'product updated was wrong',
                'status' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @OA\Delete(
     *    path="/api/v1/product/{id}",
     *   tags={"product"},
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
     *          *   @OA\Response(
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
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
//            get img src
        Storage::delete($product->img);
//            product delete
        $product->delete();

        return response()->json([
            'result' => 'product deleted successfully',
            'status' => 'success'
        ]);
    }
}
