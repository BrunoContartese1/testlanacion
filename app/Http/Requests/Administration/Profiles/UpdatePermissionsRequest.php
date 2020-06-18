<?php

namespace App\Http\Requests\Administration\Profiles;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionsRequest extends FormRequest
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
            'permissions' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'permissions.required' => 'Ha ocurrido un error de sistema al actualizar los permisos.',
            'permissions.array' => 'Ha ocurrido un error de sistema al actualizar los permisos.'
        ];
    }
}
