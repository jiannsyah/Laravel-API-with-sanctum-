<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterRawMaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_raw_material_types')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeRawMaterialType' => '00',
            'nameRawMaterialType' => 'AIR',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_raw_material_types')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeRawMaterialType' => '10',
            'nameRawMaterialType' => 'KERING',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_raw_material_types')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeRawMaterialType' => '20',
            'nameRawMaterialType' => 'BASAH',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_raw_material_types')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeRawMaterialType' => '30',
            'nameRawMaterialType' => 'BTP',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
