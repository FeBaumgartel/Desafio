<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Facades\SystemConfig;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function get(Request $request){
        return Product::when(isset($request->ids), function ($query) use ($request){
            $query->whereNotIn('id', $request->ids);
        })->get();
    }

    public function find($id){
        return Product::findOrFail($id);
    }

    public function create(ProductRequest $request){
        $product = new Product();
        $product->fill($request->only('name','value','weight','inventory'));
        $product->save();
        return $product;
    }

    public function edit(ProductRequest $request, $id){
        $product = Product::findOrFail($id);
        $product->fill($request->only('name','value','weight','inventory'));
        $product->save();
        return $product;
    }
}
