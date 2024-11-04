<?php

namespace App\Http\Resources\Master\RawMaterial;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class MasterRawMaterialCollection extends ResourceCollection
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
            'message' => 'List Raw Materials',
            'queryParams' => request()->query() ?: null,
            'data' => $this->collection->transform(function ($rawMaterials) {
                return new MasterRawMaterialResource($rawMaterials);
            })
        ];
    }
}
