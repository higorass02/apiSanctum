<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsSalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|string',
            'value' => 'required|string',
            'qtd' => 'required|integer',
            'product_sale' => 'required|integer',
        ];
    }

    public function message()
    {
        return [
            'type.required' => 'O campo type é obrigatório!',
            'value.required' => 'O campo value é obrigatório!',
            'qtd.required' => 'O campo qtd é obrigatório!',
            'product_sale.required' => 'O campo product_sale é obrigatório!',
        ];
    }
}
