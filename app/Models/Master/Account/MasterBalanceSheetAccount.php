<?php

namespace App\Models\Master\Account;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterBalanceSheetAccount extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\Master\MasterBalanceSheetAccountFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    protected $dates = ['deleted_at'];

    protected $fillable = ['numberBalanceSheetAccount', 'nameBalanceSheetAccount', 'abvBalanceSheetAccount', 'characteristicAccount', 'typeAccount', 'specialAccount', 'created_by', 'updated_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
