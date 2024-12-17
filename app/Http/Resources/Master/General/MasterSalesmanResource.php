<?php

namespace App\Http\Resources\Master\General;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterSalesmanResource extends JsonResource
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
            'codeSalesman' => $this->codeSalesman,
            'nameSalesman' => $this->nameSalesman,
            'abbreviation' => $this->abbreviation,
            // 
            'created_by' => new UserResource($this->createdBy),
        ];
    }
}
