<?php

namespace App\Http\Requests\Administration\Profiles;

use Illuminate\Foundation\Http\FormRequest;

class SearchProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('administration.profiles.view');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'searchFields' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'searchFields.required' => 'Debe escribir el criterio de busqueda.',
            'searchFields.array' => 'Ha ocurrido un error de sistema.'
        ];
    }
}
