<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Carrinho;
use App\Models\Venda;
use App\Models\VendaProduto;
use Illuminate\Http\Request;
use DB;

class VendaController extends Controller
{
    public function listar(Request $request){
        return Venda::get();
    }

    public function buscar($id){
        return Venda::with('produtos')->findOrFail($id);
    }


    public function cadastrar(VendaRequest $request){
        $venda = new Venda();
        $carrinho = Carrinho::with('produtos')->find($request->id_carrinho);

        $venda->distancia = $carrinho->distancia;
        $venda->frete = $carrinho->frete;
        $venda->subtotal = $carrinho->subtotal;
        $venda->total = $carrinho->total;
        $venda->save();

        foreach ($$carrinho->produtos as $carrinhoProduto){
            $vendaProduto = new VendaProduto();
            $vendaProduto->id_produto = $carrinhoProduto->id_produto;
            $vendaProduto->quantidade = $carrinhoProduto->quantidade;
            $vendaProduto->subtotal = $carrinhoProduto->subtotal;
            $vendaProduto->id_venda = $venda->id;
            $vendaProduto->save();
        }

        return $venda;
    }
}
