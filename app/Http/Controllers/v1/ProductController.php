<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all()->loadCount('likes')->loadCount('comments');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     *
     *
     */
    public function store(ProductRequest $request , Product $product): \Illuminate\Http\JsonResponse
    {
        $product = $request->createProduct($product);

        return response()->json([
            'product' => $product,
            'status' => 'success'
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductRequest $request , Product $product): \Illuminate\Http\JsonResponse
    {

        $product = $request->updateProduct($product);

        return response()->json([
           'product'=>$product,
           'status'=>'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = Product::destroy($id);

        return response()->json([
            'result'=>$result,
            'status'=>'success'
        ]);
    }
}
