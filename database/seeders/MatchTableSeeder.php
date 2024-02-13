<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('lottery_matches')->insert([
            [
                'match_name' => '2D',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'match_name' => '3D',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more sample data as needed
        ]);
    }
}