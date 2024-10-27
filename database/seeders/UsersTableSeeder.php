<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'jian',
                'email' => 'jianaja@gmail.com',
                'password' => bcrypt('123.321A'), // Jangan lupa bcrypt untuk password
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
