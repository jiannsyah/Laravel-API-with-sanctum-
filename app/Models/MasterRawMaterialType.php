<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRawMaterialType extends Model
{
    use HasFactory;

    use HasUuids;

    protected $fillable = ['codeRawMaterialType', 'nameRawMaterialType', 'created_by', 'updated_by'];

    public function groups()
    {
        return $this->hasMany(MasterRawMaterialGroup::class, 'codeRawMaterialType');
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
