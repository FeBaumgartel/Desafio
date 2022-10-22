<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Facades\SystemConfig;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::transaction(function () use ($request){
            $product = new Product();
            $product->fill($request->only('name','value','weight','inventory'));
            $product->save();
            return $product;
        });
    }

    public function edit(ProductRequest $request, $id){
        DB::transaction(function () use ($request, $id){
        $product = Product::findOrFail($id);
        $product->fill($request->only('name','value','weight','inventory'));
        $product->save();
        return $product;
    });
    }
}
