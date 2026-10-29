<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoleModel;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleModel::factory()->createMany([
            [
                'role_name' => 'SuperAdmin',
                'role_description' => 'Super administrator role with account management privileges.',
            ],
            [
                'role_name' => 'Admin',
                'role_description' => 'administrator role with full access to the system.',
            ],
        ]);
    }
}
