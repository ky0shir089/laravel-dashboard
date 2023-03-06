<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class storeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => 'Data Saved',
            'data' => parent::toArray($request),
        ];
    }
}
