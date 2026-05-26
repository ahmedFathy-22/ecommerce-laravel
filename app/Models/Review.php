<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'comment',
        'rating'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
