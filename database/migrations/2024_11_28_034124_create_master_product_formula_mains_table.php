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
        Schema::create('master_product_formula_mains', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codeProductFormula', 5)->unique();
            $table->string('nameProductFormula', 35);
            $table->enum('unitOfMeasurement', ['GR'])->default('GR');
            $table->integer('totalInKilograms')->default(0);
            $table->integer('totalInBks')->default(0);
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
        Schema::dropIfExists('master_product_formula_mains');
    }
};
