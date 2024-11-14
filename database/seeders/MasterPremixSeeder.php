<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterPremixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_premixes')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codePremix' => '4000101 ',
            'namePremix' => 'PREMIX-1 ALL',
            'codePremixGroup' => '40001',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('master_premixes')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codePremix' => '4000102 ',
            'namePremix' => 'PREMIX-1 MUS',
            'codePremixGroup' => '40001',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
