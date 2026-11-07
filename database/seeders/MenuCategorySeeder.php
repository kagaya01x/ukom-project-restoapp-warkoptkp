<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuCategoryModel;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuCategoryModel::factory()->createMany([
            [
                'category_name' => "Makanan"
            ],
            [
                'category_name' => "Minuman"
            ]
        ]);
    }
}
