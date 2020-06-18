<?php

namespace App\Http\Resources\Administration\Users;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $array =  [
                    'data' => $this->collection,
                    'lastPage' => method_exists($this, 'lastPage') ? $this->lastPage() : null
                ];

        return $array;
    }
}
