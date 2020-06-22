<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Sensors\CreateSensorRequest;
use App\Http\Requests\Administration\Sensors\UpdateSensorRequest;
use App\Http\Resources\Administration\Sensors\SensorCollection;
use App\Http\Resources\Administration\Sensors\SensorResource;
use App\Models\Administration\Sensor;
use Illuminate\Http\Request;

class SensorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sensor::paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSensorRequest $request)
    {
        $sensor = Sensor::create([
            'name' => $request->name,
            'x_pos' => $request->x_pos,
            'y_pos' => $request->y_pos
        ]);

        return response()->json($sensor->id, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new SensorResource( Sensor::findOrFail($id) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSensorRequest $request, $id)
    {
        $sensor = Sensor::findOrFail($id);

        $sensor->update([
            'name' => $request->name,
            'x_pos' => $request->x_pos,
            'y_pos' => $request->y_pos
        ]);

        return response()->json('Sensor actualizado con éxito', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sensor = Sensor::findOrFail($id);

        if(auth()->user()->hasPermissionTo("administration.sensors.delete")) {
            $sensor->delete();

            return response()->json('Sensor eliminado con éxito.', 200);
        }

        return response()->json('No tiene permisos para eliminar sensores.', 403);

    }

    public function nearestSensors($sensor, $quantity)
    {
        $sensor = Sensor::findOrFail($sensor);

        return $sensor->nearestSensors($quantity);
    }
}
