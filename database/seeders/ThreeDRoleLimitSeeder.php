<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThreeDigit\ThreeRoleLimit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ThreeDRoleLimitSeeder extends Seeder
{
    /**
     * Run the database seeds
     */
     public function run(): void
    {
        $roleLimits = [
            //['role_id' => 1, 'limit' => 100],
            ['role_id' => 2, 'limit' => 100000, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'limit' => 200000, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 4, 'limit' => 300000, 'created_at' => now(), 'updated_at' => now()],
           
            //['role_id' => 5, 'limit' => 500],
        ];

        foreach ($roleLimits as $roleLimit) {
            ThreeRoleLimit::create($roleLimit);
        }
    }
}