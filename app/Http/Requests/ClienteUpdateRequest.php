<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteUpdateRequest extends FormRequest
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
            'id' => 'nullable|integer|max:255',
            'name' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'dt_birthday' => 'nullable|string',
        ];
    }

    public function message()
    {
        return [
            'id.required' => 'The field "name" is required!',
        ];
    }
}
