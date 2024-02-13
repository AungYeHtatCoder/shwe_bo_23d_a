<?php

namespace Database\Seeders;

use App\Models\TwoD\TwoDLimit;
use Illuminate\Database\Seeder;
use App\Models\ThreeD\ThreeDLimit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TwoDBreakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TwoDLimit::create(['two_d_limit'=>"500"]);
        ThreeDLimit::create(['three_d_limit' => "500"]);
    }
}