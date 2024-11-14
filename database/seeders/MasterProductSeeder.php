<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_products')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeProduct' => '01001',
            'nameProduct' => 'CIRENG 10PCS',
            'mediumUnitQty' => 10,
            'largeUnitQty' => 25,
            'codeProductGroup' => '01',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('master_products')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeProduct' => '02001',
            'nameProduct' => 'NUGET 12PCS',
            'mediumUnitQty' => 12,
            'largeUnitQty' => 25,
            'codeProductGroup' => '02',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
