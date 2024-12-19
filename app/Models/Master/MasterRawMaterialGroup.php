<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterRawMaterialGroup extends Model implements Auditable
{
    use HasFactory;

    use HasUuids;

    use SoftDeletes; // Mengaktifkan soft deletes

    use \OwenIt\Auditing\Auditable;

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    protected $fillable = ['codeRawMaterialGroup', 'nameRawMaterialGroup', 'unitOfMeasurement', 'codeRawMaterialType', 'created_by', 'updated_by'];

    public function type()
    {
        return $this->belongsTo(MasterRawMaterialType::class, 'codeRawMaterialType', 'codeRawMaterialType');
    }

    public function materials()
    {
        return $this->hasMany(MasterRawMaterial::class, 'codeRawMaterialGroup');
    }

    public function premixFormula()
    {
        return $this->belongsTo(MasterPremixFormula::class, 'codeRawMaterialGroup', 'codeRawMaterialGroup');
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
