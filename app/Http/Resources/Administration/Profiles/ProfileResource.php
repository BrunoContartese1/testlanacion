<?php

namespace App\Http\Resources\Administration\Profiles;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array =  [
                    'id' => $this->id,
                    'name' => $this->name,
                    'guard_name' => $this->guard_name,
                    'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
                    'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y H:i'),
                    'permissions' => array()
                ];


        /*========================================================
                        Permisos asociados al perfil
        /*======================================================*/
        foreach($this->permissions as $permission) {
            array_push($array['permissions'], $permission->name);
        }

        /*========================================================

        /*======================================================*/

        return $array;
    }
}
