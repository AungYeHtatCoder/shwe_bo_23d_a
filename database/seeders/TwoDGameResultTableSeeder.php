<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\TwoD\TwodGameResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TwoDGameResultTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Set the starting date to today's date
        $currentDate = Carbon::now();

        // Find the closest Monday (today if it's Monday, or the next Monday)
        $startDate = $currentDate->copy()->next(Carbon::MONDAY);

        // Iterate over the next 10 years
        for ($year = 0; $year < 10; $year++) {
            // Iterate over each month in the year
            for ($month = 0; $month < 12; $month++) {
                // Iterate over each week in the month
                for ($week = 0; $week < 4; $week++) {
                    // Monday to Friday (5 days)
                    for ($day = 0; $day < 5; $day++) {
                        // Calculate the exact date based on week, month, and year
                        $date = $startDate->copy()
                            ->addYears($year) // Move through each year
                            ->addMonths($month)
                            ->addWeeks($week)
                            ->addDays($day);

                        // Determine if the calculated date is today's date
                        $isCurrentDay = $date->isSameDay($currentDate);

                        // Set status to 'open' for today's sessions, 'closed' otherwise
                        $morningStatus = $isCurrentDay ? 'open' : 'closed';
                        $eveningStatus = $isCurrentDay ? 'open' : 'closed';

                        // Morning session
                        TwodGameResult::create([
                            'result_date' => $date->format('Y-m-d'),
                            'result_time' => '12:01:00', // Morning open time
                            'session' => 'morning',
                            'status' => $morningStatus,
                        ]);

                        // Evening session
                        TwodGameResult::create([
                            'result_date' => $date->format('Y-m-d'),
                            'result_time' => '16:30:00', // Evening open time
                            'session' => 'evening',
                            'status' => $eveningStatus,
                        ]);
                    }
                }
            }
        }
    }
    //  public function run(): void
    // {
    //     // Set the starting date to today's date
    //     $currentDate = Carbon::now();

    //     // Find the closest Monday (today if it's Monday, or the next Monday)
    //     $startDate = $currentDate->copy()->next(Carbon::MONDAY);

    //     // Iterate over the next 12 months
    //     for ($month = 0; $month < 12; $month++) {
    //         // Iterate over each week in the month
    //         for ($week = 0; $week < 4; $week++) {
    //             // Monday to Friday (5 days)
    //             for ($day = 0; $day < 5; $day++) {
    //                 // Calculate the exact date based on week and day
    //                 $date = $startDate->copy()
    //                     ->addWeeks($week + 4 * $month)
    //                     ->addDays($day);

    //                 // Determine if the calculated date is today's date
    //                 $isCurrentDay = $date->isSameDay($currentDate);

    //                 // Set status to 'open' for today's sessions, 'closed' otherwise
    //                 $morningStatus = $isCurrentDay ? 'open' : 'closed';
    //                 $eveningStatus = $isCurrentDay ? 'open' : 'closed';

    //                 // Morning session
    //                 TwodGameResult::create([
    //                     'result_date' => $date->format('Y-m-d'),
    //                     'result_time' => '12:01:00', // Morning open time
    //                     'session' => 'morning',
    //                     'status' => $morningStatus,
    //                 ]);

    //                 // Evening session
    //                 TwodGameResult::create([
    //                     'result_date' => $date->format('Y-m-d'),
    //                     'result_time' => '16:30:00', // Evening open time
    //                     'session' => 'evening',
    //                     'status' => $eveningStatus,
    //                 ]);
    //             }
    //         }
    //     }
    // }
    // public function run(): void
    // {
    //     $currentDate = Carbon::now(); // Today's date

    //     // Iterate over the next 12 months
    //     for ($i = 0; $i < 12; $i++) {
    //         // Iterate over each week
    //         for ($week = 0; $week < 4; $week++) {
    //             // Monday to Friday (5 days)
    //             for ($day = 0; $day < 5; $day++) {
    //                 $date = $currentDate->copy()->addWeeks($week)->next(Carbon::MONDAY)->addDays($day);

    //                 // Determine if the date matches today's date
    //                 $isCurrentDay = $date->isSameDay($currentDate);

    //                 // Set status to 'open' only for the current day's sessions
    //                 $morningStatus = $isCurrentDay ? 'open' : 'closed';
    //                 $eveningStatus = $isCurrentDay ? 'open' : 'closed';

    //                 // Morning session
    //                 TwodGameResult::create([
    //                     'result_date' => $date->format('Y-m-d'),
    //                     'result_time' => '12:01:00', // Morning open time
    //                     'session' => 'morning', // Session identifier
    //                     'status' => $morningStatus, // Set status based on the current day
    //                 ]);

    //                 // Evening session
    //                 TwodGameResult::create([
    //                     'result_date' => $date->format('Y-m-d'),
    //                     'result_time' => '16:30:00', // Evening open time
    //                     'session' => 'evening', // Session identifier
    //                     'status' => $eveningStatus, // Set status based on the current day
    //                 ]);
    //             }
    //         }
    //     }
    // }
}