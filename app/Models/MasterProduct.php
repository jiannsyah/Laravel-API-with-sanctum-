<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProduct extends Model
{
    use HasFactory;

    use HasUuids;

    protected $fillable = ['codeProduct', 'nameProduct', 'smallUnit', 'mediumUnit', 'largeUnit', 'smallUnitQty', 'mediumUnitQty', 'largeUnitQty', 'dryUnitWeight', 'wetUnitWeight', 'wholesalePrice', 'nonWholesalePrice', 'retailPrice', 'sellingPriceUnit', 'status', 'codeProductGroup', 'created_by', 'updated_by'];

    public function group()
    {
        return $this->belongsTo(MasterProductGroup::class, 'codeProductGroup');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
