<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartRepository
{
    public static function get(){
        return Cart::get();
    }

    public static function find($id){
        return Cart::with('products.product')->findOrFail($id);
    }

    public static function create(){
        DB::beginTransaction();
        $cart = new Cart();
        $cart->save();

        DB::commit();
        return $cart;
    }

    public static function addProduct($request, $id){
        DB::beginTransaction();
        $cartProduct = new CartProduct();
        $cartProduct->fill($request);

        $product = Product::find($request->product_id);

        $cartProduct->subtotal = $request->quantity * $product->value;
        $cartProduct->cart_id = $id;
        $cartProduct->save();

        $cart = self::calcCartValues($id);
        DB::commit();

        return $cart;
    }

    public static function removeProduct($id){
        DB::beginTransaction();
        $cartProduct = CartProduct::findOrFail($id);

        $cartId = $cartProduct->cart_id;
        $cartProduct->delete();

        self::calcCartValues($cartId);
        DB::commit();
    }

    public static function setDistance($request, $id)
    {
        DB::beginTransaction();
        $cart = Cart::find($id);
        $cart->distance = $request['distance'];
        $shipping = $cart->total_weight * 5;
        if(!empty($cart->distance) && $cart->distance>100){
            $shipping = $shipping * $cart->distance / 100;
        }
        $cart->shipping = $shipping;
        $cart->save();

        DB::commit();
        return $cart;
    }

    private static function calcCartValues($id){
        $cart = Cart::with('products.product')->find($id);

        $subtotal = 0;
        foreach($cart->products as $product){
            $subtotal += $product->quantity * $product->product->value;
        }
        $cart->subtotal = $subtotal;

        $shipping = $cart->total_weight * 5;
        if(!empty($cart->distance) && $cart->distance>100){
            $shipping = $shipping * $cart->distance / 100;
        }
        $cart->shipping = $shipping;
        $cart->total = $cart->shipping + $cart->subtotal;
        $cart->save();

        return $cart;
    }
}
