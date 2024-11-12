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
        Schema::table('master_raw_material_groups', function (Blueprint $table) {
            $table->softDeletes(); // Menambahkan kolom deleted_at dengan tipe timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_raw_material_groups', function (Blueprint $table) {
            $table->dropColumn('deleted_at'); // Menghapus kolom deleted_at
        });
    }
};