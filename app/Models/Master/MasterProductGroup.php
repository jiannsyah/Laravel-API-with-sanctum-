<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterProductGroup extends Model implements Auditable
{
    use HasFactory;

    use HasUuids;

    use SoftDeletes; // Mengaktifkan soft deletes

    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['codeProductGroup', 'nameProductGroup', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date


    public function products()
    {
        return $this->hasMany(MasterProduct::class, 'codeProductGroup');
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
