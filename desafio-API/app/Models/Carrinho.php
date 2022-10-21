<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $table = 'carrinhos';

    protected $appends = ['peso_total'];


    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'carrinhos_produtos', 'id_carrinho', 'id_produto');
    }

    public function getPesoTotalAttribute(){
        $carinhoProdutos = CarrinhoProduto::with('produto')->where('id_carrinho', $this->id)->get();

        $pesoTotal = 0;

        foreach ($carinhoProdutos as $produto){
            $pesoTotal += $produto->quantidade * $produto->produto->peso;
        }
        return $pesoTotal;
    }
}
