<?php

namespace App\Models\Master\Parameter;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterParameter extends Model
{
    /** @use HasFactory<\Database\Factories\Master\Parameter\MasterParameterFactory> */
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'workDate',
    ];
}
