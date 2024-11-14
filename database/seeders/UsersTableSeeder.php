<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();

        DB::table('users')->insert([
            [
                'name' => 'jian',
                'email' => 'jianaja@gmail.com',
                'password' => bcrypt('123.321A'), // Jangan lupa bcrypt untuk password
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('users')->insert([
            [
                'name' => 'qowi',
                'email' => 'qowikuat@gmail.com',
                'password' => bcrypt('123.321A'), // Jangan lupa bcrypt untuk password
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
