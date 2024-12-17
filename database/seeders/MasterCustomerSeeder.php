<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class MasterCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_customers')->truncate();
        DB::table('master_customers')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeCustomer' => '000',
            'nameCustomer' => 'CASH',
            'abbreviation' => 'CASH',
            'ppn' => 'PPN',
            'attention' => 'CASH',
            'priceType' => 'Retail',
            'top' => 0,
            'status' => 'Active',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('master_customers')->insert([
            'id' => Str::uuid()->toString(),    // Mengisi UUID secara manual
            'codeCustomer' => '001',
            'nameCustomer' => 'CIREMAI FROZEN(H.UNE)',
            'abbreviation' => 'H.UNE',
            'addressLine1' => 'KOTA BOGOR',
            'ppn' => 'Non-PPN',
            'attention' => 'UNE',
            'priceType' => 'WholesalePrice',
            'top' => 14,
            'status' => 'Active',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
