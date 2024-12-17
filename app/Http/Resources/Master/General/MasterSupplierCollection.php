<?php

namespace App\Http\Resources\Master\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class MasterSupplierCollection extends ResourceCollection
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
            'message' => 'List Suppliers',
            'queryParams' => request()->query() ?: null,
            'data' => $this->collection->transform(function ($suppliers) {
                return new MasterSupplierResource($suppliers);
            })
        ];
    }
}
