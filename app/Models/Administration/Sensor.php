<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function nearestSensors($quantity)
    {
        $query = "SELECT id, name, SQRT( POW( (x_pos - :x0), 2) + POW( (y_pos - :y0), 2) ) AS distance, x_pos, y_pos
                  FROM sensors
                  WHERE id <> :id
                  ORDER BY distance
                  ASC LIMIT 0, :quantity";

        $bindings = [
            'x0' => $this->x_pos,
            'y0' => $this->y_pos,
            'id' => $this->id,
            'quantity' => $quantity
        ];

        return DB::select( DB::raw( $query ), $bindings );

    }
}
