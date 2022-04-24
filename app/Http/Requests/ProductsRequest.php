<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2500',
            'branch' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'type_capacity' => 'required|integer|max:255',
            'value_capacity' => 'required|string|max:255',
            'validity' => 'nullable|string',
            'price' => 'required|numeric|max:255',
            'star' => 'required|integer|max:255',
            'category_product' => 'required|integer|max:255',
        ];
    }

    public function message()
    {
        return [
            'title.required' => 'O campo title é obrigatório!',
            'description.required' => 'O campo description é obrigatório!',
            'type_capacity.required' => 'O campo type_capacity é obrigatório!',
            'value_capacity.required' => 'O campo value_capacity é obrigatório!',
            'price.required' => 'O campo price é obrigatório!',
            'star.required' => 'O campo star é obrigatório!',
            'category_product.required' => 'O campo category_product é obrigatório!',
        ];
    }
}
