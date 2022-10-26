<?php

namespace App\Repositories;


use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public static function get($request)
    {
        return Product::when(isset($request['ids']), function ($query) use ($request){
            $query->whereNotIn('id', $request['ids']);
        })->get();
    }

    public static function find($id)
    {
        return Product::findOrFail($id);
    }

    public static function create($request)
    {
        $product = new Product();
        return self::save($product, $request);
    }

    public static function edit($request, $id)
    {
        $product = Product::findOrFail($id);
        return self::save($product, $request);
    }

    private static function save($product, $request)
    {
        DB::beginTransaction();
        $product->fill($request);
        $product->save();
        DB::commit();
        return $product;
    }
}
