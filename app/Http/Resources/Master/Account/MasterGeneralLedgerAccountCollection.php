<?php

namespace App\Http\Resources\Master\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class MasterGeneralLedgerAccountCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => Response::HTTP_OK,
            'message' => 'List General Ledger Account',
            'queryParams' => request()->query() ?: null,
            'data' => $this->collection->transform(function ($GeneralLedgerAccount) {
                return new MasterGeneralLedgerAccountResource($GeneralLedgerAccount);
            })
        ];
    }
}