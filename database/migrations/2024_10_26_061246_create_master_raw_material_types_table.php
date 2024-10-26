<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_raw_material_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codeRawMaterialType', 2)->unique();
            $table->string('nameRawMaterialType', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_raw_material_types');
    }
};
