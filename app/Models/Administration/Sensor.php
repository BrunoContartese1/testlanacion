<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensors';

    protected $fillable = ['name', 'x_pos', 'y_pos'];

    protected $casts = [
        'name' => 'string',
        'x_pos' => 'integer',
        'y_pos' => 'integer'
    ];

    public static $rules = [
        'name' => 'required|unique:sensors,name',
        'x_pos' => 'required|integer',
        'y_pos' => 'required|integer'
    ];

    public static $messages = [
        'name.required' => 'Debe ingresar el nombre del sensor.',
        'x_pos.required' => 'Debe ingresar la posición X del sensor.',
        'y_pos.required' => 'Debe ingresar la posición Y del sensor.',
        'name.unique' => 'El nombre ingresado ya está siendo utilizado por otro sensor.',
        'x_pos.integer' => 'El valor de la posición X debe ser un número entero.',
        'y_pos.integer' => 'El valor de la posición Y debe ser un número entero.'
    ];
}
