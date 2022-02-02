<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequest;
use App\Models\Like;

class LikeController extends Controller
{
    public function like(LikeRequest $request, Like $like)
    {
//        get user id and product id
        $user_id = $request->user_id;
        $product_id = $request->product_id;

        // is user liked?
        $isLike = $like->getUserLiked($user_id, $product_id);

        // check for is user like the product
        if (!$isLike) {
//            add like
            $like->create([
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);

            return response()->json([
                'status'=>'success',
                'disLike' => 'Like is successfully'
            ], 201);
        } else {
//            disLike
            $like->disLike($user_id, $product_id);

            return response()->json([
                'status'=>'success',
                'disLike' => 'disLike is successfully'
            ], 201);
        }
    }
}
