<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProductGroup extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes; // Mengaktifkan soft deletes

    protected $fillable = ['codeProductGroup', 'nameProductGroup', 'created_by', 'updated_by'];


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
