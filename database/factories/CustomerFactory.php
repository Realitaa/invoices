<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_number' => $this->faker->unique()->numerify('ID####'),
            'account_name' => $this->faker->name(),
            'npwp_trems' => $this->faker->randomElement(['Yes', 'No']),
            'address' => $this->faker->address(),
            'ubis' => $this->faker->word(),
            'bisnis_area' => $this->faker->word(),
            'business_share' => $this->faker->randomFloat(2, 0, 100),
            'divisi' => $this->faker->word(),
            'witel' => $this->faker->word(),
        ];
    }
}
