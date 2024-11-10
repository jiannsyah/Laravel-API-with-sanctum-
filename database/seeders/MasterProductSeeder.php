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
            'codeProductGroup' => '90df72b4-0ff2-4351-8a7a-45252c496455',
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
            'codeProductGroup' => '5da9926f-648b-463c-a0d0-83623a71c841',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
