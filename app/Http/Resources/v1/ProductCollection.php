<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'products'=> $this->collection->map(function ($item) {
                return [
                    'title' => $item->title,
                    'descriptions' => $item->description,
                    'img' => $item->img,
                    'like_count'=>$item->likes_count,
                    'comment_count'=>$item->comments_count,
                    'category' => $item->category_id
                ];
            })
        ];
    }
}
