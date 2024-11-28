<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

        // $permission = Permission::firstOrCreate(['name' => 'create-raw-material']);
        $role = Role::firstOrCreate(['name' => 'admin']);
        // $role->givePermissionTo($permission);

        $user1 = User::create([
            'name' => 'MDS',
            'email' => 'mdsentertaiment@gmail.com',
            'password' => bcrypt('123.321A'), // Jangan lupa bcrypt untuk password
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('admin');
        $user2 = User::create([
            'name' => 'JIAN',
            'email' => 'jianaja@gmail.com',
            'password' => bcrypt('123.321A'), // Jangan lupa bcrypt untuk password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user3 = User::create([
            'name' => 'QOWI',
            'email' => 'qowikuat@gmail.com',
            'password' => bcrypt('123.321A'), // Jangan lupa bcrypt untuk password
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
