<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'orders_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function products()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
