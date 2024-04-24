<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\ThreeD\ResultDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ThreeDResultDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startYear = 2024; // Starting year
        $endYear = 2044;   // 20 years from 2024 to 2044

        // Loop through each year
        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                // Result on the 1st of each month
                $resultDate1 = Carbon::createFromDate($year, $month, 1);
                ResultDate::create([
                    'result_date' => $resultDate1->format('Y-m-d'),
                    'result_time' => '15:30:00',
                    'status' => 'closed', // Default status
                    'endpoint' => 'https://shwebo2d3dapi.online',
                ]);

                // Result on the 16th of each month
                $resultDate16 = Carbon::createFromDate($year, $month, 16);
                ResultDate::create([
                    'result_date' => $resultDate16->format('Y-m-d'),
                    'result_time' => '15:30:00',
                    'status' => 'closed',
                    'endpoint' => 'https://shwebo2d3dapi.online',
                ]);

                // Special case for December 31st
                if ($month == 12) {
                    $resultDate31 = Carbon::createFromDate($year, 12, 31);
                    ResultDate::create([
                        'result_date' => $resultDate31->format('Y-m-d'),
                    'result_time' => '15:30:00',
                    'status' => 'closed',
                    'endpoint' => 'https://shwebo2d3dapi.online',
                    ]);
                }
            }
        }

        // Now update the current and upcoming result dates to "open"
        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->month;

        // Update all results in the current month to "open"
        ResultDate::whereYear('result_date', $currentYear)
            ->whereMonth('result_date', $currentMonth)
            ->update(['status' => 'open']);
    }
    //  public function run(): void
    // {
    //     $startYear = 2024;
    //     $endYear = 2034; // 20 years from 2023 to 2042 (inclusive)

    //     // Loop through each year
    //     for ($year = $startYear; $year <= $endYear; $year++) {
    //         for ($month = 1; $month <= 12; $month++) {
    //             // Result on the 1st of the month
    //             $resultDate1 = Carbon::createFromDate($year, $month, 1);

    //             ResultDate::create([
    //                 'result_date' => $resultDate1->format('Y-m-d'),
    //                 'result_time' => '15:30:00', // Default time
    //                 'status' => 'closed', // Default status
    //                 'endpoint' => 'https://shwebo2d3dapi.online', // Add any endpoint if available
    //             ]);

    //             // Result on the 16th of the month
    //             $resultDate16 = Carbon::createFromDate($year, $month, 16);

    //             ResultDate::create([
    //                 'result_date' => $resultDate16->format('Y-m-d'),
    //                 'result_time' => '15:30:00',
    //                 'status' => 'closed',
    //                 'endpoint' => 'https://shwebo2d3dapi.online',
    //             ]);

    //             // Special case for the end of December
    //             if ($month == 12) {
    //                 $resultDate31 = Carbon::createFromDate($year, 12, 31);

    //                 ResultDate::create([
    //                     'result_date' => $resultDate31->format('Y-m-d'),
    //                     'result_time' => '15:30:00',
    //                     'status' => 'closed',
    //                     'endpoint' => 'https://shwebo2d3dapi.online',
    //                 ]);
    //             }
    //         }
    //     }
    // }
}