<?php

namespace App\Models\Master\Account;

use App\Models\Master\MasterBalanceSheetAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterGeneralLedgerAccount extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\Master\Account\MasterGeneralLedgerAccountFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    protected $dates = ['deleted_at'];

    protected $fillable = ['numberGeneralLedgerAccount', 'numberBalanceSheetAccount', 'nameGeneralLedgerAccount', 'abvGeneralLedgerAccount', 'typeAccount', 'specialAccount', 'created_by', 'updated_by'];

    public function balanceSheetAccount()
    {
        return $this->belongsTo(MasterBalanceSheetAccount::class, 'numberBalanceSheetAccount', 'numberBalanceSheetAccount');
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
