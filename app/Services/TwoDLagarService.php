<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TwoDLagarService
{
    public function getGroupedDataBySession()
{
    
 // Define time ranges for morning and evening sessions
    $morningStart = '06:00:00';
    $morningEnd = '12:00:00';
    $eveningStart = '12:00:00';
    $eveningEnd = '16:30:00';

    // Fetch morning session data
    $morningData = DB::table('lottery_two_digit_pivot')
                    ->select(
                        'two_digit_id',
                        DB::raw('SUM(sub_amount) as total_sub_amount'),
                        DB::raw('GROUP_CONCAT(DISTINCT bet_digit) as bet_digits'),
                        // prize_sent 
                        DB::raw('GROUP_CONCAT(DISTINCT prize_sent) as prize_sent'), // Add this line to get the prize_sent values
                        DB::raw('COUNT(*) as total_bets'),
                        DB::raw('MAX(created_at) as latest_bet_time') // Get the latest `created_at` time for each group
                    )
                    ->whereBetween(DB::raw('TIME(created_at)'), [$morningStart, $morningEnd])
                    ->groupBy('two_digit_id')
                    ->get();

    // Fetch evening session data
    $eveningData = DB::table('lottery_two_digit_pivot')
                    ->select(
                        'two_digit_id',
                        DB::raw('SUM(sub_amount) as total_sub_amount'),
                        DB::raw('GROUP_CONCAT(DISTINCT bet_digit) as bet_digits'),
                        DB::raw('COUNT(*) as total_bets'),
                        DB::raw('MAX(created_at) as latest_bet_time') // Get the latest `created_at` time for each group
                    )
                    ->whereBetween(DB::raw('TIME(created_at)'), [$eveningStart, $eveningEnd])
                    ->groupBy('two_digit_id')
                    ->get();

    return [
        'morning' => $morningData,
        'evening' => $eveningData,
    ];
}
   
 // public function getGroupedDataBySession($session)
    // {
    //     // Define start and end times for morning and evening sessions
    //     $times = [
    //         'morning' => ['start' => '06:00:00', 'end' => '12:00:00'],
    //         'evening' => ['start' => '12:00:00', 'end' => '16:30:00'], // 4:30 PM as 16:30
    //     ];

    //     // Ensure the session parameter is valid
    //     if (!array_key_exists($session, $times)) {
    //         return collect(); // Return an empty collection or handle this case as needed
    //     }

    //     $data = DB::table('lottery_two_digit_pivot')
    //                 ->select(DB::raw('DATE(created_at) as bet_date'), 'lottery_id', 'two_digit_id', 'bet_digit', DB::raw('SUM(sub_amount) as total_sub_amount'))
    //                 ->whereBetween(DB::raw('TIME(created_at)'), [$times[$session]['start'], $times[$session]['end']])
    //                 ->groupBy('bet_date', 'lottery_id', 'two_digit_id', 'bet_digit')
    //                 ->get();

    //     return $data;
    // }
//     public function getAllSessionsData()
// {
//     $morningTimes = ['start' => '06:00:00', 'end' => '12:00:00'];
//     $eveningTimes = ['start' => '12:00:00', 'end' => '16:30:00'];

//     $morningData = DB::table('lottery_two_digit_pivot')
//                     ->select(DB::raw('DATE(created_at) as bet_date'), 'lottery_id', 'two_digit_id', 'bet_digit', DB::raw('SUM(sub_amount) as total_sub_amount'))
//                     ->whereBetween(DB::raw('TIME(created_at)'), [$morningTimes['start'], $morningTimes['end']])
//                     ->groupBy('bet_date', 'lottery_id', 'two_digit_id', 'bet_digit')
//                     ->get();

//     $eveningData = DB::table('lottery_two_digit_pivot')
//                     ->select(DB::raw('DATE(created_at) as bet_date'), 'lottery_id', 'two_digit_id', 'bet_digit', DB::raw('SUM(sub_amount) as total_sub_amount'))
//                     ->whereBetween(DB::raw('TIME(created_at)'), [$eveningTimes['start'], $eveningTimes['end']])
//                     ->groupBy('bet_date', 'lottery_id', 'two_digit_id', 'bet_digit')
//                     ->get();

//     return ['morning' => $morningData, 'evening' => $eveningData];
// }

}