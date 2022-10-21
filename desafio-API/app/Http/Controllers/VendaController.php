<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Facades\SystemConfig;
use App\Models\Venda;
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

    //Distancias até 100km considerar somente valor calculado do peso do pedido,
    //Distancias maiores que 100km considerar valor calculado do peso do pedido vezes distancia da entrega divido por 100.
    public function calcularFrete(Request $request){
        if($request->distancia>100){
            return $request->subtotal*$request->distancia/100;
        }
        return $request->subtotal
    }

    public function cadastrar(VendaRequest $request){
        $venda = new Venda();
        $venda->fill($request->only('distancia'));
        $venda->save();

        $peso = 0;
        $subtotal = 0;
        foreach($request->produtos as $produto){
            $produtoBanco = Produto::findOrFail($produto->id);
            $vendaProduto = new VendaProduto();
            $vendaProduto->id_produto = $produto->id_produto;
            $vendaProduto->id_venda = $venda->id;
            $vendaProduto->quantidade = $produto->quantidade;
            $vendaProduto->valor = $produtoBanco->valor*$produto->quantidade;
            $subtotal +=$vendaProduto->valor;
            $peso +=$produto->quantidade*$produtoBanco->peso;
        }
        $frete = $peso *5;

        if($request->distancia>100){
            $frete =  $frete*$request->distancia/100;
        }
        $venda->subtotal = $subtotal;
        $venda->frete = $frete;
        $venda->total = $frete + $subtotal;
        $venda->save();

        return $venda;
    }

    public function editar(VendaRequest $request, $id){
        $venda = Venda::findOrFail($id);
        $venda->fill($request->only('distancia','subtotal','frete','total'));
        $venda->save();
        return $venda;
    }
}
