<?php

namespace Database\Seeders;

use App\Models\Admin\CountryCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countryCodes = [
            ["name" => "MM(+95)", "code" => "+95"],
            ["name" => "THA(+66)", "code" => "+66"],
        ];
        
        foreach ($countryCodes as $country) {
            CountryCode::create($country);
        }
    }
}
