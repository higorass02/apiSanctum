<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchedulingRequest extends FormRequest
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
            'id_cliente' => 'required|integer|max:255',
            'id_services' => 'required|integer|max:10',
            'dt_scheduling' => 'required|string|max:255',
        ];
    }

    public function message()
    {
        return [
            'id_cliente.required' => 'The Field id_cliente is required!',
            'id_services.required' => 'The Field id_services is required!'
        ];
    }
}
