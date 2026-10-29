<?php

namespace Database\Factories;

use App\Models\EmployeeModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeModel>
 */
class EmployeeModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->randomElement(['Manager', 'Chef', 'Waiter', 'Cashier']),
            'employee_id' => $this->faker->unique()->numerify('EMP###'),
            'image_link' => $this->faker->imageUrl(640, 480, 'people'),
        ];
    }
}
