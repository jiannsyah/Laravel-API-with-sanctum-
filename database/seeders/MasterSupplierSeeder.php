<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_suppliers')->truncate();
        DB::table('master_suppliers')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeSupplier' => '001',
            'nameSupplier' => 'PT.ABC',
            'abbreviation' => 'PT.ABC',
            'ppn' => 'PPN',
            'attention' => 'PT.ABC',
            'top' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_suppliers')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeSupplier' => '002',
            'nameSupplier' => 'PT.Frozen',
            'abbreviation' => 'PT.Frozen',
            'ppn' => 'PPN',
            'attention' => 'PT.Frozen',
            'top' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }
}
