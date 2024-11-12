<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPremix extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['codePremix', 'namePremix', 'unitOfMeasurement', 'status', 'codePremixGroup', 'created_by', 'updated_by'];

    use SoftDeletes; // Mengaktifkan soft deletes

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    public function group()
    {
        return $this->belongsTo(MasterPremixGroup::class, 'codePremixGroup');
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
