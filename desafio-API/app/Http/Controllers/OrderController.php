<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function get(Request $request){
        return Order::get();
    }

    public function find($id){
        return Order::with('products')->findOrFail($id);
    }


    public function create(OrderRequest $request){
        DB::transaction(function () use ($request){
            $order = new Order();
            $cart = Cart::with('products')->find($request->cart_id);

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

            return $order;
        });
    }
}
