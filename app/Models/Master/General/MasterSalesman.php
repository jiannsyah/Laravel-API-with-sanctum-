<?php

namespace App\Models\Master\General;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterSalesman extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\MasterSalesmanFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

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
