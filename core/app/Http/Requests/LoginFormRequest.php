<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
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
            'cz1_cc' => 'required|integer',
            'cz1_contrasena' => 'required'
        ];
    }
    public function messages()
{
    return [
        'cz1_cc.required' => 'la cedula es obligatoria.',
        'cz1_cc.integer' => 'la cedula no es valida.',
        'cz1_contrasena.required' => 'La clave es obligatoria',
       
    ];
}
}
