<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeModel;


class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeModel::create([
            'name' => 'John Doe',
            'position' => 'Manager',
            'work_id' => 'EMP001',
            'image_link' => 'https://example.com/images/john_doe.jpg'
        ]);
    }
}
