<?php

namespace App\Http\Resources\Master\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class MasterSalesmanCollection extends ResourceCollection
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
            'message' => 'List Salesmen',
            'queryParams' => request()->query() ?: null,
            'data' => $this->collection->transform(function ($salesman) {
                return new MasterSalesmanResource($salesman);
            })
        ];
    }
}
