<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsStockRequest extends FormRequest
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
            'quantity' => 'required|integer',
            'product_stock' => 'required|integer|max:255',
        ];
    }

    public function message()
    {
        return [
            'title.quantity' => 'O campo quantity é obrigatório!',
            'product_stock.required' => 'O campo product_stock é obrigatório!',
        ];
    }
}
