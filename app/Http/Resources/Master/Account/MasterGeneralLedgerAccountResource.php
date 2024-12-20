<?php

namespace App\Http\Resources\Master\Account;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterGeneralLedgerAccountResource extends JsonResource
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
            'numberGeneralLedgerAccount' => $this->numberGeneralLedgerAccount,
            'nameGeneralLedgerAccount' => $this->nameGeneralLedgerAccount,
            'abvGeneralLedgerAccount' => $this->abvGeneralLedgerAccount,
            'typeAccount' => $this->typeAccount,
            'specialAccount' => $this->specialAccount,
            'balanceSheetAccount' => $this->whenLoaded('balanceSheetAccount', function () {
                return [
                    'numberBalanceSheetAccount' => $this->balanceSheetAccount->numberBalanceSheetAccount,
                    'nameBalanceSheetAccount' => $this->balanceSheetAccount->nameBalanceSheetAccount, // Mengembalikan hanya nama
                ];
            }),
            // 
            'created_by' => new UserResource($this->createdBy),
        ];
    }
}
