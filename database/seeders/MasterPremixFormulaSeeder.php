<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterPremixFormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_premix_formulas')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codePremix' => '4000101 ',
            'squenceNumber' => '01',
            'codeRawMaterialGroup' => '10001',
            'quantity' => 150,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
