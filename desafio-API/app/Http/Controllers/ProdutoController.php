<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Facades\SystemConfig;
use App\Models\Produto;
use Illuminate\Http\Request;
use DB;

class ProdutoController extends Controller
{
    public function listar(Request $request){
        return Produto::when(isset($request->ids), function ($query) use ($request){
            $query->whereNotIn('id', $request->ids);
        })->get();
    }

    public function buscar($id){
        return Produto::findOrFail($id);
    }

    public function cadastrar(ProdutoRequest $request){
        $produto = new Produto();
        $produto->fill($request->only('nome','valor','peso','estoque'));
        $produto->save();
        return $produto;
    }

    public function editar(ProdutoRequest $request, $id){
        $produto = Produto::findOrFail($id);
        $produto->fill($request->only('nome','valor','peso','estoque'));
        $produto->save();
        return $produto;
    }
}
