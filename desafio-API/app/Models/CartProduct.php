<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $table = 'carts_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function products()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_cart');
    }
}
