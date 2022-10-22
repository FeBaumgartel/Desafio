<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'quantity'=> 'required|integer',
            'distance'=> 'sometimes|integer'
        ];
    }
}
