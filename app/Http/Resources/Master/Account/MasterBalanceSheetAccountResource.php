<?php

namespace App\Http\Resources\Master\Account;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterBalanceSheetAccountResource extends JsonResource
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
            'numberBalanceSheetAccount' => $this->numberBalanceSheetAccount,
            'nameBalanceSheetAccount' => $this->nameBalanceSheetAccount,
            'abvBalanceSheetAccount' => $this->abvBalanceSheetAccount,
            'characteristicAccount' => $this->characteristicAccount,
            'typeAccount' => $this->typeAccount,
            'specialAccount' => $this->specialAccount,
            // 
            'created_by' => new UserResource($this->createdBy),
        ];
    }
}
