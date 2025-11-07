<?php

namespace App\Domains\Product\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];
}