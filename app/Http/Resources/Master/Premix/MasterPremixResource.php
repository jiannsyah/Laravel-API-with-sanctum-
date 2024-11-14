<?php

namespace App\Http\Resources\Master\Premix;

use App\Http\Resources\UserResource;
use Carbon\Carbon;
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
            'unitOfMeasurement' => $this->unitOfMeasurement,
            'status' => $this->status,
            // 
            'group' => $this->whenLoaded('group', function () {
                return [
                    'codePremixGroup' => $this->group->codePremixGroup,
                    'namePremixGroup' => $this->group->namePremixGroup, // Mengembalikan hanya nama
                ];
            }),
            'deleted_at' => $this->deleted_at ? Carbon::parse($this->deleted_at)->format('Y-m-d H:i:s') : 'Not Deleted',
            'created_by' => new UserResource($this->createdBy),
        ];
    }
}
