<?php

namespace Database\Factories;

use App\Models\RoleModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoleModel>
 */
class RoleModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_name' => $this->faker->word(),
            'role_description' => $this->faker->sentence(),
        ];
    }
}
