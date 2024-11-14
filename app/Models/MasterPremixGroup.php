<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPremixGroup extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes; // Mengaktifkan soft deletes

    protected $fillable = ['codePremixGroup', 'namePremixGroup', 'created_by', 'updated_by'];

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
