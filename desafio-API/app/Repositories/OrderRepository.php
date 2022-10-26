<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public static function get(){
        return Order::withCount('products')->get();
    }

    public static function find($id){
        return Order::with('products')->findOrFail($id);
    }

    public static function create($request){
        DB::beginTransaction();
        $order = new Order();
        $cart = Cart::with('products')->find($request['cart_id']);

        $order->distance = $cart->distance;
        $order->shipping = $cart->shipping;
        $order->subtotal = $cart->subtotal;
        $order->total = $cart->total;
        $order->save();

        foreach ($cart->products as $cartProduct){
            $orderProduct = new OrderProduct();
            $orderProduct->product_id = $cartProduct->product_id;
            $orderProduct->quantity = $cartProduct->quantity;
            $orderProduct->subtotal = $cartProduct->subtotal;
            $orderProduct->order_id = $order->id;
            $orderProduct->save();

            $cartProduct->delete();
        }
        $cart->delete();

        DB::commit();
        return $order;
    }

    public static function productsOrder($id){
        return OrderProduct::with('product')->where('order_id', $id)->get();
    }
}
