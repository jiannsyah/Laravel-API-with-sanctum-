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
        Schema::create('master_customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codeCustomer', 5)->unique();
            $table->string('nameCustomer', 50);
            $table->string('abbreviation', 30);
            $table->string('addressLine1', 75)->nullable();
            $table->string('addressLine2', 75)->nullable();
            $table->enum('ppn', ['PPN', 'Non-PPN'])->default('PPN');
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('attention', 50)->nullable();
            $table->enum('priceType', ['WholesalePrice', 'NonWholesalePrice', 'Retail'])->default('WholesalePrice');
            $table->integer('top')->default(0);
            $table->string('npwp', 25)->nullable();
            $table->string('nik', 25)->nullable();
            $table->enum('status', ['Active', 'InActive'])->default('Active');
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
        Schema::dropIfExists('master_customers');
    }
};
