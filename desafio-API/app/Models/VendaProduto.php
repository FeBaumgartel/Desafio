<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendaProduto extends Model
{
    protected $table = 'vendas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function produtos()
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }
    public function venda()
    {
        return $this->belongsTo(Venda::class, 'id_venda');
    }
}
