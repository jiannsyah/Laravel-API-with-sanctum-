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
        Schema::create('master_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codeProduct', 8)->unique();
            $table->string('nameProduct', 255);
            $table->enum('smallUnit', ['BTR', 'PCS'])->default('BTR');
            $table->enum('mediumUnit', ['PACK'])->default('PACK');
            $table->enum('largeUnit', ['BAL', 'DUS'])->default('BAL');
            $table->integer('smallUnitQty')->default(1);
            $table->integer('mediumUnitQty')->default(1);
            $table->integer('largeUnitQty')->default(1);
            $table->integer('dryUnitWeight')->default(0);
            $table->integer('wetUnitWeight')->default(0);
            // 
            $table->decimal('wholesalePrice')->default(0);
            $table->decimal('nonWholesalePrice')->default(0);
            $table->decimal('retailPrice')->default(0);
            // 
            $table->enum('sellingPriceUnit', ['BTR', 'PCS', 'PACK', 'BAL', 'DUS'])->default('BTR');
            $table->enum('status', ['Active', 'Non-Active'])->default('Active');
            // 
            $table->integer('quantityStockGood')->default(0);
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
            $table->uuid('codeProductGroup'); // Kolom untuk foreign key
            $table->foreign('codeProductGroup')->references('codeProductGroup')->on('master_product_groups')->onDelete('cascade'); // Menetapkan relasi ke tabel users
            // 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_products');
    }
};
