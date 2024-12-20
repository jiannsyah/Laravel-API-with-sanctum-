<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterGeneralLedgerAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_general_ledger_accounts')->truncate();
        DB::table('master_general_ledger_accounts')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'numberGeneralLedgerAccount' => '110101',
            'numberBalanceSheetAccount' => '110100',
            'nameGeneralLedgerAccount' => 'KAS BESAR (1)',
            'abvGeneralLedgerAccount' => 'KAS BESAR (1)',
            'typeAccount' => 'AK',
            'specialAccount' => 'KS',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_general_ledger_accounts')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'numberGeneralLedgerAccount' => '110102',
            'numberBalanceSheetAccount' => '110100',
            'nameGeneralLedgerAccount' => 'KAS BESAR (2)',
            'abvGeneralLedgerAccount' => 'KAS BESAR (2)',
            'typeAccount' => 'AK',
            'specialAccount' => 'KS',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),

        ]);
    }
}
