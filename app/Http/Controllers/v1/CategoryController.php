<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\v1\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoryCollection|Category[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
//        get and show all categories
        $category = Category::paginate(10);
        return new CategoryCollection($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request): \Illuminate\Http\JsonResponse
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request,Category $category): \Illuminate\Http\JsonResponse
    {
//        update category
        $category = $category->update($request->all());

        if ($category){
            return response()->json([
                'category'=>$category,
                'result'=>'category added successfully',
                'status'=>'success'
            ]);
        }else{
            return response()->json([
                'category'=>$category,
                'result'=>'category added was wrong',
                'status'=>'success'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
//        delete category
        Category::destroy($id);

        return response()->json([
            'result' => 'category deleted successfully',
            'status'=>'success'
        ]);
    }
}
