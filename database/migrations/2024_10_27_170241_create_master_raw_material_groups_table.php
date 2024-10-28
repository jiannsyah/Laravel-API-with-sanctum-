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
        Schema::create('master_raw_material_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codeRawMaterialGroup', 5)->unique();
            $table->string('nameRawMaterialGroup', 50);
            $table->enum('unitOfMeasurement', ['KG', 'LTR', 'PCS'])->default('KG');
            // 
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            // 
            $table->uuid('codeRawMaterialType'); // Kolom untuk foreign key
            $table->foreign('codeRawMaterialType')->references('id')->on('master_raw_material_types')->onDelete('cascade'); // Menetapkan relasi ke tabel users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_raw_material_groups');
    }
};
