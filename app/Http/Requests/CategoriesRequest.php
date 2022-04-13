<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'spotlight' => 'required|boolean',
        ];
    }

    public function message()
    {
        return [
            'title.required' => 'O campo title é obrigatorio!',
            'description.required' => 'O campo description é obrigatorio!',
            'spotlight.required' => 'O campo spotlight é obrigatorio!'

        ];
    }
}
