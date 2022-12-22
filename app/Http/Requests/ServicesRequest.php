<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesRequest extends FormRequest
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
            'type' => 'nullable|integer|max:1',
            'desc' => 'nullable|string|max:255',
        ];
    }

    public function message()
    {
        return [
        ];
    }
}
