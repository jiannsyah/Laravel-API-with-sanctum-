<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRawMaterialGroup extends Model
{
    use HasFactory;

    use HasUuids;

    protected $fillable = ['codeRawMaterialGroup', 'nameRawMaterialGroup', 'codeRawMaterialType'];

    public function type()
    {
        return $this->belongsTo(MasterRawMaterialType::class, 'codeRawMaterialType');
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
