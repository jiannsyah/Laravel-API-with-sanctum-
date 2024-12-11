<?php

namespace App\Http\Resources\Master\Premix;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterPremixFormulaResource extends JsonResource
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
            'codePremix' => $this->codePremix,
            'squenceNumber' => $this->squenceNumber,
            'codeRawMaterialGroup' => $this->codeRawMaterialGroup,
            'quantity' => $this->quantity,
            'unitOfMeasurement' => $this->unitOfMeasurement,
            'created_by' => new UserResource($this->createdBy),
            'updated_by' => new UserResource($this->updatedBy)
        ];
    }
}
