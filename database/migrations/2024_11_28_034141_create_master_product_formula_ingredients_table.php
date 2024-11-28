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
        Schema::create('master_product_formula_ingredients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // 
            $table->uuid('codeProductFormula'); // Kolom untuk foreign key
            $table->foreign('codeProductFormula')->references('codeProductFormula')->on('master_product_formula_mains')->onDelete('cascade'); // Menetapkan relasi ke tabel users
            $table->enum('typeOfSupportingMaterial', ['BB', 'PX']);
            $table->string('squenceNumber', 2)->unique();
            // 
            $table->string('codeSupportingMaterial', 8); //satu kolom relasi 2 tabel. di cek di be nya saja
            $table->integer('quantity')->default(0);
            $table->enum('unitOfMeasurement', ['BKS', 'GR']);
            $table->string('notes', 50)->default('');
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
        Schema::dropIfExists('master_product_formula_ingredients');
    }
};
