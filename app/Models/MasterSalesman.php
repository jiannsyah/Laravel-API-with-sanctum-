<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSalesman extends Model
{
    /** @use HasFactory<\Database\Factories\MasterSalesmanFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected $fillable = ['codeSalesman', 'nameSalesman', 'abbreviation',  'created_by', 'updated_by'];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
