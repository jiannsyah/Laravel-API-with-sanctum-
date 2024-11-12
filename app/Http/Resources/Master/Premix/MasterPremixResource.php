<?php

namespace App\Http\Resources\Master\Premix;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterPremixResource extends JsonResource
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
            'namePremix' => $this->namePremix,
            'uniOfMeasurement' => $this->smallUnit,
            'status' => $this->status,
            // 
            'group' => $this->whenLoaded('group', function () {
                return [
                    'codePremixGroup' => $this->group->codePremixGroup,
                    'namePremixGroup' => $this->group->namePremixGroup, // Mengembalikan hanya nama
                ];
            }),
            'created_by' => new UserResource($this->createdBy),
        ];
    }
}
