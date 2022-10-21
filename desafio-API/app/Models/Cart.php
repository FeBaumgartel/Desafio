<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $appends = ['weight_total'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts_products', 'id_cart', 'id_product');
    }

    public function getPesoTotalAttribute(){
        $carinhoProducts = CartProduct::with('product')->where('id_cart', $this->id)->get();

        $weightTotal = 0;

        foreach ($carinhoProducts as $product){
            $weightTotal += $product->quantity * $product->product->weight;
        }
        return $weightTotal;
    }
}
