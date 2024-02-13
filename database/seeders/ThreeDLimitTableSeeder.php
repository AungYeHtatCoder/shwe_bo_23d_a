<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ThreeDLimitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('three_d_limits')->insert([
            [
                'three_d_limit' => '500',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}