<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'cart_id' => 'required|exists:carts,id'
        ];
    }
}
