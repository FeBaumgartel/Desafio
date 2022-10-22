<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $table = 'carts_products';

    protected $fillable = ['product_id', 'quantity'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }
}
