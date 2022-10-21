<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    public function get(Request $request){
        return Order::get();
    }

    public function find($id){
        return Order::with('products')->findOrFail($id);
    }


    public function create(OrderRequest $request){
        $order = new Order();
        $cart = Cart::with('products')->find($request->id_cart);

        $order->distance = $cart->distance;
        $order->shipping = $cart->shipping;
        $order->subtotal = $cart->subtotal;
        $order->total = $cart->total;
        $order->save();

        foreach ($$cart->products as $cartProduct){
            $orderProduct = new OrderProduct();
            $orderProduct->id_product = $cartProduct->id_product;
            $orderProduct->quantity = $cartProduct->quantity;
            $orderProduct->subtotal = $cartProduct->subtotal;
            $orderProduct->id_order = $order->id;
            $orderProduct->save();
        }

        return $order;
    }
}