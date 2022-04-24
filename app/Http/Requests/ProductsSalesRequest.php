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
            'qtd' => 'required|integer',
            'dt_expired' => 'required|string',
            'product_sale' => 'required|integer',
        ];
    }

    public function message()
    {
        return [
            'qtd.required' => 'O campo qtd é obrigatório!',
            'dt_expired.required' => 'O campo dt_expired é obrigatório!',
            'product_sale.required' => 'O campo product_sale é obrigatório!',
        ];
    }
}
