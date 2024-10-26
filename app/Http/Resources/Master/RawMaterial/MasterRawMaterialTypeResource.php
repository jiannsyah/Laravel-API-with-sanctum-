<?php

namespace App\Http\Resources\Master\RawMaterial;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterRawMaterialTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'codeRawMaterialType' => $this->codeRawMaterialType,
            'nameRawMaterialType' => $this->nameRawMaterialType,
        ];
    }
}
