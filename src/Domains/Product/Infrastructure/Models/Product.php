<?php

namespace App\Domains\Product\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'category'];
}