<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterProduct extends Model implements Auditable
{
    use HasFactory;

    use HasUuids;

    use SoftDeletes; // Mengaktifkan soft deletes

    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['codeProduct', 'nameProduct', 'smallUnit', 'mediumUnit', 'largeUnit', 'smallUnitQty', 'mediumUnitQty', 'largeUnitQty', 'dryUnitWeight', 'wetUnitWeight', 'wholesalePrice', 'nonWholesalePrice', 'retailPrice', 'sellingPriceUnit', 'status', 'codeProductGroup', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    public function group()
    {
        return $this->belongsTo(MasterProductGroup::class, 'codeProductGroup', 'codeProductGroup');
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
