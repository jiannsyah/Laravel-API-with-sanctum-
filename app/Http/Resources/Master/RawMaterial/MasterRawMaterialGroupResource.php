<?php

namespace App\Http\Resources\Master\RawMaterial;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterRawMaterialGroupResource extends JsonResource
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
            'codeRawMaterialGroup' => $this->codeRawMaterialGroup,
            'nameRawMaterialGroup' => $this->nameRawMaterialGroup,
            'unitOfMeasurement' => $this->unitOfMeasurement,
            // 
            'type' => $this->whenLoaded('type', function () {
                return [
                    'codeRawMaterialType' => $this->type->codeRawMaterialType,
                    'nameRawMaterialType' => $this->type->nameRawMaterialType, // Mengembalikan hanya nama
                ];
            }),
            // 
            'created_by' => new UserResource($this->createdBy),
            'updated_by' => new UserResource($this->updatedBy)

            // 'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
        ];
    }
}
