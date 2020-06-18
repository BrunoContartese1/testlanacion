<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Debe ingresar su nombre de usuario.',
            'username.exists' => 'El nombre de usuario ingresado no existe en nuestros registros.',
            'password.required' => 'Debe ingresar su contraseña.'
        ];
    }
}
