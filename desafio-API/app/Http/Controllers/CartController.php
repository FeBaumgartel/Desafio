<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function get(Request $request){
        return Cart::get();
    }

    public function find($id){
        return Cart::with('products')->findOrFail($id);
    }

    public function create(){
        $cart = new Cart();
        $cart->save();

        return $cart;
    }

    public function addProduct(CartRequest $request, $id){
        $cartProduct = new CartProduct();
        $cartProduct->fill($request->only('product_id', 'quantity'));

        $product = Product::find($request->product_id);

        $cartProduct->subtotal = $request->quantity * $product->value;
        $cartProduct->cart_id = $id;
        $cartProduct->save();

        $cart = Cart::find($id);
        $cart->subtotal += $cartProduct->subtotal;

        $shipping = $cart->total_weight * 5;
        if(!empty($cart->distance) && $request->distance>100){
            $shipping = $shipping * $request->distance / 100;
        }
        $cart->shipping = $shipping;
        $cart->total = $cart->shipping + $cart->subtotal;
        $cart->save();

        return $cart;
    }
}
