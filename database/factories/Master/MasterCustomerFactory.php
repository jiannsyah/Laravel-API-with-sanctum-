<?php

namespace Database\Factories\Master;

use App\Models\Master\MasterCustomer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasterCustomer>
 */
class MasterCustomerFactory extends Factory
{
    protected $model = MasterCustomer::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ppn_choice = ['PPN', 'Non-PPN'];
        $priceType_choice = ['WholesalePrice', 'NonWholesalePrice', 'Retail'];
        $status_choice = ['Active', 'InActive'];
        return [
            'codeCustomer' => Str::random(5),
            'nameCustomer' => $this->faker->name(),
            'abbreviation' => $this->faker->firstName(),
            'addressLine1' => $this->faker->address(),
            'ppn' => $ppn_choice[array_rand($ppn_choice)],
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'attention' => $this->faker->firstName(),
            'priceType' =>  $priceType_choice[array_rand($priceType_choice)],
            'top' => $this->faker->numberBetween(0, 28),
            'npwp' => $this->faker->numerify('##############'),
            'nik' => $this->faker->numerify('##############'), // 16 digit angka
            'status' => $status_choice[array_rand($status_choice)],
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
