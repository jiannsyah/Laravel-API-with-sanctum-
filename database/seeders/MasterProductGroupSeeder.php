<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_product_groups')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeProductGroup' => '01',
            'nameProductGroup' => 'CIRENG',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_product_groups')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeProductGroup' => '02',
            'nameProductGroup' => 'NUGET',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
