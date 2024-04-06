<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $games = [
            ['name' => 'Game 1', 'image' => 'game1.png', 'link' => 'https://shwebo2d3dapi.online', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Game 2', 'image' => 'game2.png', 'link' => 'https://shwebo2d3dapi.online', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Game 3', 'image' => 'game3.png', 'link' => 'https://shwebo2d3dapi.online', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Game 4', 'image' => 'game4.png', 'link' => 'https://shwebo2d3dapi.online', 'created_at' => now(), 'updated_at' => now()],
            // Add more games here if needed
        ];

        DB::table('games')->insert($games);
    }
}