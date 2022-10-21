<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        $isPost = $this->isMethod('post');
        return [
            'name' => Rule::requiredIf($isPost) . '|string|max:255',
            'value'=> Rule::requiredIf($isPost) . '|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'weight'=> Rule::requiredIf($isPost) . '|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'inventory'=> 'integer'
        ];
    }
}
