<?php

namespace App\Http\Resources\Master\RawMaterial;

use App\Http\Resources\UserResource;
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
            'created_by' => new UserResource($this->createdBy),
            'updated_by' => new UserResource($this->updatedBy)

            // 'created_at' => (new Carbon($this->created_at))->format('Y-m-d'),
        ];
    }
}
