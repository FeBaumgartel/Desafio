<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrinhoProduto extends Model
{
    protected $table = 'carrinhos_produtos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function produtos()
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }
    public function carrinho()
    {
        return $this->belongsTo(Carrinho::class, 'id_carrinho');
    }
}
