<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     *@OA\Get (
     *   path="/api/v1/commnets",
     *   tags={"comment"},
     *   summary="main",
     *   security={{"bearerAuth":{}}},
     *   description="main page ",
     *
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
     * @return mixed
     */
    public function comments()
    {
//        get and show all comment
        return Comment::paginate(5);
    }

    public function add_comment(CommentRequest $request)
    {
        // create new comment and replay
        return Comment::create([
            'body' => $request->body,
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'parent_id' => $request->parent_id ?? 0
        ]);
    }
}
