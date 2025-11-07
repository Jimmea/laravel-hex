<?php

namespace App\Domains\Order\Infrastructure\Models;

use App\Domains\Product\Infrastructure\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}