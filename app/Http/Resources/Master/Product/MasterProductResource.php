<?php

namespace App\Http\Resources\Master\Product;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterProductResource extends JsonResource
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
            'codeProduct' => $this->codeProduct,
            'nameProduct' => $this->nameProduct,
            'smallUnit' => $this->smallUnit,
            'mediumUnit' => $this->mediumUnit,
            'largeUnit' => $this->largeUnit,
            'smallUnitQty' => $this->smallUnitQty,
            'mediumUnitQty' => $this->mediumUnitQty,
            'largeUnitQty' => $this->largeUnitQty,
            // 
            'dryUnitWeight' => $this->dryUnitWeight,
            'wetUnitWeight' => $this->wetUnitWeight,
            'wholesalePrice' => $this->wholesalePrice,
            'nonWholesalePrice' => $this->nonWholesalePrice,
            'retailPrice' => $this->retailPrice,
            'sellingPriceUnit' => $this->sellingPriceUnit,
            // 
            'status' => $this->status,
            // 
            'group' => $this->whenLoaded('group', function () {
                return [
                    'codeProductGroup' => $this->group->codeProductGroup,
                    'nameProductGroup' => $this->group->nameProductGroup, // Mengembalikan hanya nama
                ];
            }),
            'created_by' => new UserResource($this->createdBy),
        ];
    }
}
