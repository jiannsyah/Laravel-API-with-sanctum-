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
        Schema::create('master_balance_sheet_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('numberBalanceSheetAccount', 8)->unique();
            $table->string('nameBalanceSheetAccount', 50)->unique();
            $table->string('abvBalanceSheetAccount', 30)->unique();
            $table->enum('characteristicAccount', ['Header', 'Total', 'Account']);
            $table->enum('typeAccount', ['AK', 'PS', 'PD', 'BY', 'LL']);
            $table->enum('specialAccount', ['KS', 'BK', 'RE', 'PCY', 'GENERAL']);
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
        Schema::dropIfExists('master_balance_sheet_accounts');
    }
};
