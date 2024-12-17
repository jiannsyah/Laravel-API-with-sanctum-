<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSupplier extends Model
{
    /** @use HasFactory<\Database\Factories\MasterSupplierFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['codeSupplier', 'nameSupplier', 'abbreviation', 'addressLine1', 'addressLine2', 'ppn', 'phone', 'email', 'attention', 'top', 'created_by', 'updated_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
