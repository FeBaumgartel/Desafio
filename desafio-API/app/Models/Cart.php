<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $appends = ['total_weight'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts_products', 'cart_id', 'product_id');
    }

    //TODO - transformar em sum
    public function getTotalWeightAttribute(){
        $cartProducts = CartProduct::with('product')->where('cart_id', $this->attributes['id'])->get();

        $totalWeight = 0;

        foreach ($cartProducts as $product){
            $totalWeight += $product->quantity * $product->product->weight;
        }
        return $totalWeight;
    }
}
