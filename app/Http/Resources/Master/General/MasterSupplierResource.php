<?php

namespace App\Http\Resources\Master\General;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterSupplierResource extends JsonResource
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
            'codeSupplier' => $this->codeSupplier,
            'nameSupplier' => $this->nameSupplier,
            'abbreviation' => $this->abbreviation,
            'addressLine1' => $this->addressLine1,
            'addressLine2' => $this->addressLine2,
            'ppn' => $this->ppn,
            'phone' => $this->phone,
            'email' => $this->email,
            'attention' => $this->attention,
            'top' => $this->top,
            // 
            'created_by' => new UserResource($this->createdBy),
        ];
    }
}
