<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterProductFormulaIngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_product_formula_ingredients')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeProductFormula' => 'B0001',
            'typeOfSupportingMaterial' => 'BB',
            'squenceNumber' => '01',
            'codeSupportingMaterial' => '1000101',
            'quantity' => 150,
            'unitOfMeasurement' => 'GR',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
