<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Facades\SystemConfig;
use App\Models\Cart;
use App\Models\Cart;
use Illuminate\Http\Request;
use DB;

class CartController extends Controller
{
    public function get(Request $request){
        return Cart::get();
    }

    public function find($id){
        return Cart::with('products')->findOrFail($id);
    }

    public function create(CartRequest $request){
        $cart = new Cart();
        $cart->save();

        return $cart;
    }

    public function addProduct(CartRequest $request, $id){
        $cartProduct = new CartProduct();
        $cartProduct->fill($request->only('id_product', 'quantity'));

        $product = Product::find($request->id_product);

        $cartProduct->subtotal = $request->quantity * $product->value;
        $cartProduct->id_cart = $id;
        $cartProduct->save();

        $cart = Cart::find($id);
        $cart->subtotal +=$cartProduct->subtotal;
        $cartProduct->weightTotal = $request->quantity * $product->weight;

        if(!empty($cart->distance)){

        $shipping = $cartProduct->weightTotal *5;

        if($request->distance>100){
            $shipping =  $shipping*$request->distance/100;
        }
        $cart->shipping = $shipping;
        $cart->total =$cart->shipping+$cart->subtotal;
        }
        $cart->save();
        return $cart;
    }
}
