<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TwoD\TwoDigit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            ThreeDigitsTableSeeder::class,
            ThreeDLimitTableSeeder::class,
            TwoDigitsTableSeeder::class,
            TwoDLimitTableSeeder::class,
            TwoDBreakSeeder::class,
            MatchTableSeeder::class,
            RoleLimitSeeder::class,
        ]);
    }
}