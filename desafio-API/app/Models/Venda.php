<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'distancia',
        'subtotal',
        'frete',
        'total',
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'vendas_produtos', 'id_venda', 'id_produto');
    }
}
