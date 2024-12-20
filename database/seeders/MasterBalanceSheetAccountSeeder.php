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
            'numberBalanceSheetAccount' => '110000',
            'nameBalanceSheetAccount' => 'AKTIVA LANCAR',
            'abvBalanceSheetAccount' => 'AKTIVA LANCAR',
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
            'numberBalanceSheetAccount' => '110100',
            'nameBalanceSheetAccount' => 'KAS',
            'abvBalanceSheetAccount' => 'KAS',
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
            'numberBalanceSheetAccount' => '110200',
            'nameBalanceSheetAccount' => 'BANK',
            'abvBalanceSheetAccount' => 'BANK',
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
            'numberBalanceSheetAccount' => '119999',
            'nameBalanceSheetAccount' => 'TOTAL AKTIVA LANCAR',
            'abvBalanceSheetAccount' => 'TOTAL AKTIVA LANCAR',
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
