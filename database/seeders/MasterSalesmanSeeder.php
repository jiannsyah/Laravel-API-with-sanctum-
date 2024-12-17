<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterSalesmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_salesmen')->truncate();
        DB::table('master_salesmen')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeSalesman' => '01',
            'nameSalesman' => 'OFFICE',
            'abbreviation' => 'OFFICE',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
