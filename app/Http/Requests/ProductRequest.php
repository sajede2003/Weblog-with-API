<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required|min:10',
            'img' => 'required|mimes:jpg,png,jpeg|max:5048',
            'category_id' => 'required',
        ];

    }

    public function createProduct()
    {
//        validate data
        $validData = (object)$this->validated();
//      insert img src in database and storage file
        $path = $this->file('img')->store('public/uploads/images');
//         create new product
        return Product::create([
            'title' => $validData->title,
            'description' => $validData->description,
            'img' => $path,
            'category_id' => $validData->category_id
        ]);
    }

    public function updateProduct($product)
    {
//        get valid data
        $validData = (object)$this->validated();
//        check if has img delete img in db and storage
        if ($product->img != '' && $product->img != null) {
            Storage::delete($product->img);
        }
//        insert new img
        $path = $this->file('img')->store('public/uploads/images');
//        update product
        return $product->update([
            'title' => $validData->title,
            'description' => $validData->description,
            'img' => $path,
            'category_id' => $validData->category_id
        ]);
    }
}