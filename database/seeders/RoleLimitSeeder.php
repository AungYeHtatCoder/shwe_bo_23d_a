<?php

namespace Database\Seeders;

use App\Models\RoleLimit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleLimits = [
            ['role_id' => 2, 'limit' => 10000, 'created_at' =>now(), 'updated_at' => now()], // Silver
            ['role_id' => 3, 'limit' => 20000, 'created_at' =>now(), 'updated_at' => now()], // Gold
            ['role_id' => 4, 'limit' => 50000, 'created_at' =>now(), 'updated_at' => now()], // Diamond
        ];

        foreach ($roleLimits as $roleLimit) {
            RoleLimit::create($roleLimit);
        }
    }
    
}