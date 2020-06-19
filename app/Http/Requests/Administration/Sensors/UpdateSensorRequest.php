<?php

namespace App\Http\Requests\Administration\Sensors;

use App\Models\Administration\Sensor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSensorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('administration.sensors.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Sensor::$rules;

        $rules['name'] = 'required|unique:sensors,name,' . $this->route()->parameter('sensor');

        return $rules;
    }

    public function messages()
    {
        return Sensor::$messages;
    }
}
