<?php

namespace App\Http\Resources\Master\RawMaterial;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MasterRawMaterialCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
