<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Category[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): \Illuminate\Http\JsonResponse
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        $category = Category::create($request->all());

        return response()->json([
            'product' => $category,
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request,Category $category): \Illuminate\Http\JsonResponse
    {
        $category = $category->update($request->all());

        return response()->json([
           'category'=>$category,
           'status'=>'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        $category->delete();

        return response()->json([
            'result' => 'category deleted successfully',
            'status'=>'success'
        ]);
    }
}
