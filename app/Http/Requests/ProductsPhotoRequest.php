<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsPhotoRequest extends FormRequest
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
            'URL' => 'required|string',
            'product_photo' => 'required|int',
        ];
    }

    public function message()
    {
        return [
            'URL.required' => 'O campo URL é obrigatório!',
            'product_photo.required' => 'O campo product_photo é obrigatório!',
        ];
    }
}
