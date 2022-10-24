<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Exception;
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
        DB::beginTransaction();
            $cart = new Cart();
            $cart->save();

            DB::commit();
            return $cart;
    }

    public function addProduct(CartRequest $request, $id){
        DB::beginTransaction();
            $cartProduct = new CartProduct();
            $cartProduct->fill($request->only('product_id', 'quantity'));

            $product = Product::find($request->product_id);

            $cartProduct->subtotal = $request->quantity * $product->value;
            $cartProduct->cart_id = $id;
            $cartProduct->save();

            DB::commit();
            return $this->calcCartValues($id);
    }
    public function removeProduct($id){
        DB::beginTransaction();
        try {
            $cartProduct = CartProduct::findOrFail($id);
            
            $cartId = $cartProduct->cart_id;
            $cartProduct->delete();

            $this->calcCartValues($cartId);
            DB::commit();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }

    }

    public function setDistance(Request $request, $id){

        DB::beginTransaction();
            $cart = Cart::find($id);
            $cart->distance = $request->distance;
            $shipping = $cart->total_weight * 5;
            if(!empty($cart->distance) && $cart->distance>100){
                $shipping = $shipping * $cart->distance / 100;
            }
            $cart->shipping = $shipping;
            $cart->save();
            DB::commit();
            return $cart;
    }

    private function calcCartValues($id){
        $cart = Cart::with('products.product')->find($id);

        $subtotal = 0;
        foreach($cart->products as $product){

            $subtotal += $product->quantity * $product->value;
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
