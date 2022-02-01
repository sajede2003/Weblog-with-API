<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

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

    public function createProduct($product)
    {
        $validData = (object)$this->validated();
        $newImageName = $this->uploadImg($product);

        return Product::create([
            'title' => $validData->title,
            'description' => $validData->description,
            'img' => $newImageName,
            'category_id' => $validData->category_id
        ]);
    }

    public function updateProduct($product)
    {
        $validData = (object)$this->validated();

        $newImageName = $this->uploadImg($product);

        return $product->update([
            'title' => $validData->title,
            'description' => $validData->description,
            'img' => $newImageName,
            'category_id' => $validData->category_id
        ]);
    }

    public function uploadImg($product)
    {
        $validData = (object)$this->validated();

        if ($validData->img != '') {
            $path = public_path() . '/uploads/images/';

            //for remove old file
            if ($product->img != '' && $product->img != null) {
                $file_old = $path . $product->img;
                unlink($file_old);
            }

            //upload new file
            $file = $validData->img;
            $filename =$file->getClientOriginalName();
            $file->move($path, $filename);

            //for update in table
            return $filename;
        }
    }
}