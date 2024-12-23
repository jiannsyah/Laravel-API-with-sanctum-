<?php

namespace App\Models\Master\Premix;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterPremixGroup extends Model implements Auditable
{
    use HasFactory;

    use HasUuids;

    use SoftDeletes; // Mengaktifkan soft deletes

    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['codePremixGroup', 'namePremixGroup', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    public function premixes()
    {
        return $this->hasMany(MasterPremix::class, 'codePremixGroup');
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
