<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPremixFormula extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes; // Mengaktifkan soft deletes

    protected $fillable = ['codePremix', 'squenceNumber', 'quantity', 'unitOfMeasurement', 'created_by', 'updated_by'];
    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    public function premix()
    {
        return $this->belongsTo(MasterPremix::class, 'codePremix');
    }

    public function rawMaterialGroups()
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
