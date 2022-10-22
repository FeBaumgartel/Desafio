<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function get(Request $request){
        return Cart::get();
    }

    public function find($id){
        return Cart::with('products.product')->findOrFail($id);
    }

    public function create(){
        DB::transaction(function (){
            $cart = new Cart();
            $cart->save();

            return $cart;
        });
    }

    public function addProduct(CartRequest $request, $id){
        DB::transaction(function () use ($request, $id){
            $cartProduct = new CartProduct();
            $cartProduct->fill($request->only('product_id', 'quantity'));

            $product = Product::find($request->product_id);

            $cartProduct->subtotal = $request->quantity * $product->value;
            $cartProduct->cart_id = $id;
            $cartProduct->save();

            $cart = Cart::find($id);
            $cart->subtotal += $cartProduct->subtotal;

            $shipping = $cart->total_weight * 5;
            if(!empty($cart->distance) && $cart->distance>100){
                $shipping = $shipping * $cart->distance / 100;
            }
            $cart->shipping = $shipping;
            $cart->total = $cart->shipping + $cart->subtotal;
            $cart->save();

            return $cart;
        });
    }

    public function setDistance(Request $request, $id){

        DB::transaction(function () use ($request, $id){
            $cart = Cart::find($id);
            $cart->distance = $request->distance;
            $shipping = $cart->total_weight * 5;
            if(!empty($cart->distance) && $cart->distance>100){
                $shipping = $shipping * $cart->distance / 100;
            }
            $cart->shipping = $shipping;
            $cart->save();
            return $cart;
        });
    }
}
