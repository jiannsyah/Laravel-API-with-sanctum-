<?php

namespace App\Http\Resources\Master\RawMaterial;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterRawMaterialResource extends JsonResource
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
            'codeRawMaterial' => $this->codeRawMaterial,
            'nameRawMaterial' => $this->nameRawMaterial,
            'unitOfMeasurement' => $this->unitOfMeasurement,
            'status' => $this->status,
            'brand' => $this->brand,
            'costPrice' => $this->costPrice,
            // 
            'type' => $this->whenLoaded('type', function () {
                return [
                    'codeRawMaterialType' => $this->type->codeRawMaterialType,
                    'nameRawMaterialType' => $this->type->nameRawMaterialType, // Mengembalikan hanya nama
                ];
            }),
            // 
            'group' => $this->whenLoaded('group', function () {
                return [
                    'codeRawMaterialGroup' => $this->group->codeRawMaterialGroup,
                    'nameRawMaterialGroup' => $this->group->nameRawMaterialGroup, // Mengembalikan hanya nama
                ];
            }),
            // 
            'created_by' => new UserResource($this->createdBy),
            // 'updated_by' => new UserResource($this->updatedBy)

        ];
    }
}
