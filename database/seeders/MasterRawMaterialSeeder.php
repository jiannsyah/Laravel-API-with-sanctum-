<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterRawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_raw_materials')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeRawMaterial' => '10001001 ',
            'nameRawMaterial' => 'TKS',
            'codeRawMaterialType' => 'd7dbd3f7-cfa3-4e5e-9e8a-9002d0a86daa',
            'codeRawMaterialGroup' => 'ae89494b-5e64-4e9b-b2bc-d3e388d57c12',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('master_raw_materials')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeRawMaterial' => '10001002 ',
            'nameRawMaterial' => 'SPM',
            'codeRawMaterialType' => 'd7dbd3f7-cfa3-4e5e-9e8a-9002d0a86daa',
            'codeRawMaterialGroup' => 'ae89494b-5e64-4e9b-b2bc-d3e388d57c12',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
