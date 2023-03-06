<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class deleteResource extends JsonResource
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
            'message' => 'Data Deleted',
            'data' => parent::toArray($request),
        ];
    }
}
