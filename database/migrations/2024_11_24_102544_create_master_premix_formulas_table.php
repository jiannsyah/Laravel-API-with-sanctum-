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
        Schema::create('master_premix_formulas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('codePremix'); // Kolom untuk foreign key
            $table->foreign('codePremix')->references('codePremix')->on('master_premixes')->onDelete('cascade'); // Menetapkan relasi ke tabel users
            $table->string('squenceNumber', 2)->unique();
            //  
            $table->uuid('codeRawMaterialGroup'); // Kolom untuk foreign key
            $table->foreign('codeRawMaterialGroup')->references('codeRawMaterialGroup')->on('master_raw_material_groups')->onDelete('cascade'); // Menetapkan relasi ke tabel users
            // 
            $table->integer('quantity')->default(0);
            $table->enum('unitOfMeasurement', ['GR'])->default('GR');
            // 
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->softDeletes(); // Menambahkan kolom deleted_at untuk soft delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_premix_formulas');
    }
};
