<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Facades\SystemConfig;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function get(Request $request)
    {
        try {
            return ProductRepository::get($request->only('ids'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function find($id)
    {
        try {
            return ProductRepository::find($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function create(ProductRequest $request)
    {
        try {
            return ProductRepository::create($request->only('name','description','value','weight','inventory'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function edit(ProductRequest $request, $id)
    {
        try {
            return ProductRepository::edit($request->only('name','description','value','weight','inventory'), $id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getStatus());
        }
    }
}
