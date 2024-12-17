<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCustomer extends Model
{
    /** @use HasFactory<\Database\Factories\MasterCustomerFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['codeCustomer', 'nameCustomer', 'abbreviation', 'addressLine1', 'addressLine2', 'ppn', 'phone', 'email', 'attention', 'priceType', 'top', 'npwp', 'nik', 'status', 'created_by', 'updated_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
