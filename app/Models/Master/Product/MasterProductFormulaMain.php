<?php

namespace App\Models\Master\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MasterProductFormulaMain extends Model implements Auditable
{
    use HasFactory;

    use HasUuids;

    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    protected $dates = ['deleted_at']; // Menandakan kolom deleted_at sebagai tipe date

    public function ingredients()
    {
        return $this->hasMany(MasterProductFormulaIngredients::class, 'codeProductFormula');
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
