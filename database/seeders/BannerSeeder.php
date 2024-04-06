<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $banners = [
            ['image' => '1.png', 'created_at' => now(), 'updated_at' => now()],
            ['image' => '2.png', 'created_at' => now(), 'updated_at' => now()],
            ['image' => '3.png', 'created_at' => now(), 'updated_at' => now()],
            // Add more banners here if needed
        ];

        DB::table('banners')->insert($banners);
    }

}