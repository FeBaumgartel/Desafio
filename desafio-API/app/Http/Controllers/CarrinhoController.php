<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Facades\SystemConfig;
use App\Models\Carrinho;
use App\Models\Carrinho;
use Illuminate\Http\Request;
use DB;

class CarrinhoController extends Controller
{
    public function listar(Request $request){
        return Carrinho::get();
    }

    public function buscar($id){
        return Carrinho::with('produtos')->findOrFail($id);
    }

    public function cadastrar(CarrinhoRequest $request){
        $carrinho = new Carrinho();
        $carrinho->save();

        return $carrinho;
    }

    public function adicionarProduto(CarrinhoRequest $request, $id){
        $carrinhoProduto = new CarrinhoProduto();
        $carrinhoProduto->fill($request->only('id_produto', 'quantidade'));

        $produto = Produto::find($request->id_produto);

        $carrinhoProduto->subtotal = $request->quantidade * $produto->valor;
        $carrinhoProduto->id_carrinho = $id;
        $carrinhoProduto->save();

        $carrinho = Carrinho::find($id);
        $carrinho->subtotal +=$carrinhoProduto->subtotal;
        $carrinhoProduto->pesoTotal = $request->quantidade * $produto->peso;

        if(!empty($carrinho->distancia)){

        $frete = $carrinhoProduto->pesoTotal *5;

        if($request->distancia>100){
            $frete =  $frete*$request->distancia/100;
        }
        $carrinho->frete = $frete;
        $carrinho->total =$carrinho->frete+$carrinho->subtotal;
        }
        $carrinho->save();
        return $carrinho;
    }
}
