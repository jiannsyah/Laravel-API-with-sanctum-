<?php

namespace App\Http\Resources\Master\Parameter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterParameterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
