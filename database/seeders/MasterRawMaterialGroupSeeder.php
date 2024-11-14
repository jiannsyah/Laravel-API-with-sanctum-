<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterRawMaterialGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_raw_material_groups')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeRawMaterialGroup' => '10001',
            'nameRawMaterialGroup' => 'TAPIOKA',
            'unitOfMeasurement' => 'KG',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'codeRawMaterialType' => '10'
        ]);
        DB::table('master_raw_material_groups')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeRawMaterialGroup' => '10002',
            'nameRawMaterialGroup' => 'AREN',
            'unitOfMeasurement' => 'KG',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'codeRawMaterialType' => '10'
        ]);
    }
}
