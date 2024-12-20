<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRawMaterialType extends Model
{
    use HasFactory;

    use HasUuids;

    use SoftDeletes; // Mengaktifkan soft deletes

    protected $table = 'master_raw_material_types';

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    protected $fillable = ['codeRawMaterialType', 'nameRawMaterialType', 'created_by', 'updated_by'];

    public function groups()
    {
        return $this->hasMany(MasterRawMaterialGroup::class, 'codeRawMaterialType');
    }

    public function materials()
    {
        return $this->hasMany(MasterRawMaterial::class, 'codeRawMaterialType');
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
