<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function get(Request $request){
        return CartRepository::get();
    }

    public function find($id){
        try {
            return CartRepository::find($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function create()
    {
        try {
            return CartRepository::create();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function addProduct(CartRequest $request, $id)
    {
        try {
            return CartRepository::addProduct($request->only('product_id', 'quantity'), $id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function removeProduct($id){
        try {
            CartRepository::removeProduct($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function setDistance(Request $request, $id)
    {
        try {
            return CartRepository::setDistance($request->only('distance'), $id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }
}
