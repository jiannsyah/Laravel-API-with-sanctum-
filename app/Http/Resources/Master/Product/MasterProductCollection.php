<?php

namespace App\Http\Resources\Master\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class MasterProductCollection extends ResourceCollection
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
            'message' => 'List Products',
            'queryParams' => request()->query() ?: null,
            'data' => $this->collection->transform(function ($products) {
                return new MasterProductResource($products);
            })
        ];
    }
}
