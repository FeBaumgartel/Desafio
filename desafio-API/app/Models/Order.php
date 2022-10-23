<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $appends = ['total_weight'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'distance',
        'subtotal',
        'shipping',
        'total',
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function getTotalWeightAttribute(){
        $orderProducts = OrderProduct::with('product')->where('order_id', $this->attributes['id'])->get();

        $totalWeight = 0;

        foreach ($orderProducts as $product){
            $totalWeight += $product->quantity * $product->product->weight;
        }
        return $totalWeight;
    }
}
