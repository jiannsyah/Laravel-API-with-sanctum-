<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProductFormulaMain extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
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
