<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'users'=>$this->collection->map(function ($item){
                return [
                    'name'=>$item->name,
                    'email'=>$item->email,
                    'level'=>$item->when($item->is_admin ===1 , 'admin' , 'user')
                ];
            })
        ];
    }
}
