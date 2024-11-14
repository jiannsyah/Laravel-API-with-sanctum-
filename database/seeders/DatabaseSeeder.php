<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Article::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(MasterRawMaterialTypeSeeder::class);
        $this->call(MasterRawMaterialGroupSeeder::class);
        $this->call(MasterRawMaterialSeeder::class);
        // 
        $this->call(MasterProductGroupSeeder::class);
        $this->call(MasterProductSeeder::class);
        // 
        $this->call(MasterPremixGroupSeeder::class);
        $this->call(MasterPremixSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
