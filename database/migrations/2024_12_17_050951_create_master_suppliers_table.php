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
        Schema::create('master_suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codeSupplier', 5)->unique();
            $table->string('nameSupplier', 40);
            $table->string('abbreviation', 20);
            $table->string('addressLine1', 50)->nullable();
            $table->string('addressLine2', 50)->nullable();
            $table->enum('ppn', ['PPN', 'Non-PPN'])->default('PPN');
            $table->string('phone', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('attention')->nullable();
            $table->integer('top')->default(0);
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
        Schema::dropIfExists('master_suppliers');
    }
};
