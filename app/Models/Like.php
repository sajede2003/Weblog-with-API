<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    public function getUserLiked($userId, $productId)
    {
        return Like::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }

    public function disLike($userId, $productId)
    {
        Like::where('user_id', $userId)->where('product_id', $productId)->delete();
    }


    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
