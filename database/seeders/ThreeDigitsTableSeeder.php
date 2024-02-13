<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThreeDigitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Empty the table before seeding
        DB::table('three_digits')->truncate();

        $digits = [];

        // Generate numbers from 001 to 999
        for ($i = 0; $i <= 999; $i++) {
            // Convert the number to a string with leading zeros
            $number = str_pad($i, 3, '0', STR_PAD_LEFT);

            $digits[] = [
                'three_digit' => $number,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert in chunks to avoid memory issues
            if ($i % 100 == 0) {
                DB::table('three_digits')->insert($digits);
                $digits = [];
            }
        }

        // Insert any remaining digits
        if (!empty($digits)) {
            DB::table('three_digits')->insert($digits);
        }
    }
    
}