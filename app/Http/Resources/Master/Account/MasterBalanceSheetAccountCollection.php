<?php

namespace App\Http\Resources\Master\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class MasterBalanceSheetAccountCollection extends ResourceCollection
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
            'message' => 'List Balance Sheet Accounts',
            'queryParams' => request()->query() ?: null,
            'data' => $this->collection->transform(function ($BalanceSheetAccount) {
                return new MasterBalanceSheetAccountResource($BalanceSheetAccount);
            })
        ];
    }
}
