<?php

namespace App\Models\Master\RawMaterial;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterRawMaterial extends Model implements Auditable
{
    use HasFactory;

    use HasUuids;

    use \OwenIt\Auditing\Auditable;

    use SoftDeletes; // Mengaktifkan soft deletes

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    protected $fillable = ['codeRawMaterial', 'nameRawMaterial', 'brand', 'unitOfMeasurement', 'status', 'costPrice', 'codeRawMaterialType', 'codeRawMaterialGroup', 'created_by', 'updated_by'];

    protected $attributes = [
        'brand' => 'LOCAL'
    ];

    public function type()
    {
        return $this->belongsTo(MasterRawMaterialType::class, 'codeRawMaterialType', 'codeRawMaterialType');
    }

    public function group()
    {
        return $this->belongsTo(MasterRawMaterialGroup::class, 'codeRawMaterialGroup');
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
