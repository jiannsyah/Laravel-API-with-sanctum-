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
        Schema::create('master_raw_materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codeRawMaterial', 8)->unique();
            $table->string('nameRawMaterial', 255);
            $table->string('brand', 50)->default('LOCAL');
            $table->enum('unitOfMeasurement', ['KG', 'LTR', 'PCS'])->default('KG');
            $table->enum('status', ['Active', 'Non-Active'])->default('Active');
            // 
            $table->decimal('costPrice', 12, 2)->default(0);
            $table->integer('quantityStockGood')->default(0);
            // 
            $table->integer('quantityMonth01')->default(0);
            $table->integer('quantityMonth02')->default(0);
            $table->integer('quantityMonth03')->default(0);
            $table->integer('quantityMonth04')->default(0);
            $table->integer('quantityMonth05')->default(0);
            $table->integer('quantityMonth06')->default(0);
            $table->integer('quantityMonth07')->default(0);
            $table->integer('quantityMonth08')->default(0);
            $table->integer('quantityMonth09')->default(0);
            $table->integer('quantityMonth10')->default(0);
            $table->integer('quantityMonth11')->default(0);
            $table->integer('quantityMonth12')->default(0);
            // 
            $table->integer('priceAverageMonth01')->default(0);
            $table->integer('priceAverageMonth02')->default(0);
            $table->integer('priceAverageMonth03')->default(0);
            $table->integer('priceAverageMonth04')->default(0);
            $table->integer('priceAverageMonth05')->default(0);
            $table->integer('priceAverageMonth06')->default(0);
            $table->integer('priceAverageMonth07')->default(0);
            $table->integer('priceAverageMonth08')->default(0);
            $table->integer('priceAverageMonth09')->default(0);
            $table->integer('priceAverageMonth10')->default(0);
            $table->integer('priceAverageMonth11')->default(0);
            $table->integer('priceAverageMonth12')->default(0);
            // 
            $table->integer('amountMonth01')->default(0);
            $table->integer('amountMonth02')->default(0);
            $table->integer('amountMonth03')->default(0);
            $table->integer('amountMonth04')->default(0);
            $table->integer('amountMonth05')->default(0);
            $table->integer('amountMonth06')->default(0);
            $table->integer('amountMonth07')->default(0);
            $table->integer('amountMonth08')->default(0);
            $table->integer('amountMonth09')->default(0);
            $table->integer('amountMonth10')->default(0);
            $table->integer('amountMonth11')->default(0);
            $table->integer('amountMonth12')->default(0);
            // 
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            // 
            $table->uuid('codeRawMaterialGroup'); // Kolom untuk foreign key
            $table->foreign('codeRawMaterialGroup')->references('id')->on('master_raw_material_groups')->onDelete('cascade'); // Menetapkan relasi ke tabel users
            $table->uuid('codeRawMaterialType'); // Kolom untuk foreign key
            $table->foreign('codeRawMaterialType')->references('id')->on('master_raw_material_types')->onDelete('cascade'); // Menetapkan relasi ke tabel users
            // 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_raw_materials');
    }
};
