<?php

namespace App\Http\Requests\Administration\Profiles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('administration.profiles.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name,' . $this->route()->parameter('Profile')
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe ingresar un nombre para el nuevo perfil.',
            'name.unique' => 'El nombre ingresado ya corresponde a un perfil del sistema.'
        ];
    }
}
