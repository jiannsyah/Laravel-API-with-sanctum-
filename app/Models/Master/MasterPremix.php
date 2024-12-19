<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterPremix extends Model implements Auditable
{
    use HasFactory;

    use HasUuids;

    use \OwenIt\Auditing\Auditable;

    use SoftDeletes; // Mengaktifkan soft deletes

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    protected $fillable = ['codePremix', 'namePremix', 'unitOfMeasurement', 'status', 'codePremixGroup', 'created_by', 'updated_by'];

    public function group()
    {
        return $this->belongsTo(MasterPremixGroup::class, 'codePremixGroup', 'codePremixGroup');
    }

    public function formulas()
    {
        return $this->hasMany(MasterPremixFormula::class, 'codePremix');
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
