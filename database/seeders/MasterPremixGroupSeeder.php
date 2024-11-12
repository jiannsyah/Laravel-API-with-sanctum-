<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterPremixGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_premix_groups')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codePremixGroup' => '40001',
            'namePremixGroup' => 'PREMIX-1 (BTP)',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_premix_groups')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codePremixGroup' => '40002',
            'namePremixGroup' => 'PREMIX-2 (BUM)',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
