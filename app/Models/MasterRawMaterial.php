<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRawMaterial extends Model
{
    use HasFactory;

    use HasUuids;

    protected $fillable = ['codeRawMaterial', 'nameRawMaterial', 'brand', 'unitOfMeasurement', 'status', 'costPrice', 'codeRawMaterialType', 'codeRawMaterialGroup', 'created_by', 'updated_by'];

    protected $attributes = [
        'brand' => 'LOCAL'
    ];

    use SoftDeletes; // Mengaktifkan soft deletes

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

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
