<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
//        get and show all users
        return Product::all()->loadCount('likes')->loadCount('comments');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     *
     *
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
