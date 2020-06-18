<?php

namespace App\Http\Resources\Administration\Profiles;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionGroupsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
