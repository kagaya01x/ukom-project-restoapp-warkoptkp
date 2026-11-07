<?php

namespace Database\Factories;

use App\Models\MenuCategoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeModel>
 */
class MenuCategoryModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_name' => $this->faker->name(),
        ];
    }
}
