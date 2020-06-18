<?php

namespace App\Http\Resources\Administration\Profiles;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfileCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'lastPage' => method_exists($this, 'lastPage') ? $this->lastPage() : null
        ];
    }
}
