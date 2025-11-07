<?php

namespace App\Domains\Product\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    protected $fillable = ['user_id', 'product_id', 'viewed_at'];
}