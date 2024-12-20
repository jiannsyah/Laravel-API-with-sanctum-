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
        Schema::create('master_general_ledger_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('numberGeneralLedgerAccount', 8)->unique();
            $table->string('nameGeneralLedgerAccount', 50)->unique();
            $table->string('abvGeneralLedgerAccount', 30)->unique();
            $table->enum('typeAccount', ['AK', 'PS', 'PD', 'BY', 'LL']);
            $table->enum('specialAccount', ['KS', 'BK', 'RE', 'PCY', 'GENERAL']);
            // 
            $table->integer('valueMonth01')->default(0);
            $table->integer('valueMonth02')->default(0);
            $table->integer('valueMonth03')->default(0);
            $table->integer('valueMonth04')->default(0);
            $table->integer('valueMonth05')->default(0);
            $table->integer('valueMonth06')->default(0);
            $table->integer('valueMonth07')->default(0);
            $table->integer('valueMonth08')->default(0);
            $table->integer('valueMonth09')->default(0);
            $table->integer('valueMonth10')->default(0);
            $table->integer('valueMonth11')->default(0);
            $table->integer('valueMonth12')->default(0);
            // 
            $table->string('numberBalanceSheetAccount', 8);
            $table->foreign('numberBalanceSheetAccount')->references('numberBalanceSheetAccount')->on('master_balance_sheet_accounts')->onDelete('cascade');
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
        Schema::dropIfExists('master_general_ledger_accounts');
    }
};
