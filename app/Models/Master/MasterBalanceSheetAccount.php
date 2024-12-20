<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterBalanceSheetAccount extends Model
{
    /** @use HasFactory<\Database\Factories\Master\MasterBalanceSheetAccountFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['numberAccount', 'nameAccountBalance', 'abbreviation', 'characteristicAccount', 'typeAccount', 'specialAccount', 'created_by', 'updated_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
