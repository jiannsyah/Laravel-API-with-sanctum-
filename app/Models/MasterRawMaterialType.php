<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRawMaterialType extends Model
{
    use HasFactory;

    use HasUuids;

    protected $connection = 'mysql'; // atau nama koneksi lainnya

    protected $table = 'master_raw_material_types';

    protected $fillable = ['codeRawMaterialType', 'nameRawMaterialType'];
}
