<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'value'=> 'sometimes|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'weight'=> 'sometimes|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'inventory'=> 'sometimes|integer'
        ];
    }

}
