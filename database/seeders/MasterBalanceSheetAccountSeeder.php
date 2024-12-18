<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterBalanceSheetAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_balance_sheet_accounts')->truncate();
        DB::table('master_balance_sheet_accounts')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'numberAccount' => '110000',
            'nameAccountBalance' => 'AKTIVA LANCAR',
            'abbreviation' => 'AKTIVA LANCAR',
            'characteristicAccount' => 'Header',
            'typeAccount' => 'AK',
            'specialAccount' => 'KS',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_balance_sheet_accounts')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'numberAccount' => '110100',
            'nameAccountBalance' => 'KAS',
            'abbreviation' => 'KAS',
            'characteristicAccount' => 'Account',
            'typeAccount' => 'AK',
            'specialAccount' => 'KS',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_balance_sheet_accounts')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'numberAccount' => '110200',
            'nameAccountBalance' => 'BANK',
            'abbreviation' => 'BANK',
            'characteristicAccount' => 'Account',
            'typeAccount' => 'AK',
            'specialAccount' => 'KS',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_balance_sheet_accounts')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'numberAccount' => '119999',
            'nameAccountBalance' => 'TOTAL AKTIVA LANCAR',
            'abbreviation' => 'TOTAL AKTIVA LANCAR',
            'characteristicAccount' => 'Total',
            'typeAccount' => 'AK',
            'specialAccount' => 'KS',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
