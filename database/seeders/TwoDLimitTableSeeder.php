<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TwoDLimitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('two_d_limits')->insert([
            [
                'two_d_limit' => '5000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]); 
    }
}