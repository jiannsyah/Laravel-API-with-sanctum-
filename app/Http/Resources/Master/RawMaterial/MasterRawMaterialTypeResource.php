<?php

namespace App\Http\Resources\Master\RawMaterial;

use Carbon\Carbon;
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
            'id' => $this->id,
            'codeRawMaterialType' => $this->codeRawMaterialType,
            'nameRawMaterialType' => $this->nameRawMaterialType,
            // 'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
        ];
    }
}
