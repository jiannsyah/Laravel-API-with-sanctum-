<?php

namespace App\Http\Resources\Master\General;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterCustomerResource extends JsonResource
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
            'codeCustomer' => $this->codeCustomer,
            'nameCustomer' => $this->nameCustomer,
            'abbreviation' => $this->abbreviation,
            'addressLine1' => $this->addressLine1,
            'addressLine2' => $this->addressLine2,
            'ppn' => $this->ppn,
            'phone' => $this->phone,
            'email' => $this->email,
            'attention' => $this->attention,
            'priceType' => $this->priceType,
            'top' => $this->top,
            'npwp' => $this->npwp,
            'nik' => $this->nik,
            'status' => $this->status,
            // 
            'created_by' => new UserResource($this->createdBy),
        ];
    }
}
