<?php

namespace App\Models\Master;

use App\Models\User;
use App\Traits\FilterReports\Master\Customer\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterCustomer extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\MasterCustomerFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

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
