<?php
namespace App\Services;
use Carbon\Carbon;
use App\Models\TwoD\TwoDigit;
use Illuminate\Support\Facades\DB;

class TwoDigitDataService {
    

  public function getTwoDigitsData() {
        // Use Carbon to define morning and evening session times
        $morningStart = Carbon::today()->setTime(6, 0, 0); // 6:00 AM
        $morningEnd = Carbon::today()->setTime(12, 0, 0); // 12:00 PM
        $eveningStart = Carbon::today()->setTime(12, 0, 0); // 12:00 PM
        $eveningEnd = Carbon::today()->setTime(16, 30, 0); // 4:30 PM

        $twoDigits = TwoDigit::all();
        $data = [];
        
        foreach ($twoDigits as $digit) {
            // Adjust queries to use Carbon instances for time comparison
            $morningData = DB::table('lottery_two_digit_pivot')
                            ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
                            ->where('two_digit_id', $digit->id)
                            ->whereBetween(DB::raw('TIME(lotteries.created_at)'), [$morningStart->toTimeString(), $morningEnd->toTimeString()])
                            ->select(
                                'lottery_two_digit_pivot.two_digit_id',
                                DB::raw('SUM(lottery_two_digit_pivot.sub_amount) as total_sub_amount'),
                                DB::raw('GROUP_CONCAT(DISTINCT lottery_two_digit_pivot.bet_digit) as bet_digits'),
                                DB::raw('COUNT(*) as total_bets'),
                                DB::raw('MAX(lotteries.created_at) as latest_bet_time')
                            )
                            ->groupBy('lottery_two_digit_pivot.two_digit_id')
                            ->first();

            $eveningData = DB::table('lottery_two_digit_pivot')
                            ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
                            ->where('two_digit_id', $digit->id)
                            ->whereBetween(DB::raw('TIME(lotteries.created_at)'), [$eveningStart->toTimeString(), $eveningEnd->toTimeString()])
                            ->select(
                                'lottery_two_digit_pivot.two_digit_id',
                                DB::raw('SUM(lottery_two_digit_pivot.sub_amount) as total_sub_amount'),
                                DB::raw('GROUP_CONCAT(DISTINCT lottery_two_digit_pivot.bet_digit) as bet_digits'),
                                DB::raw('COUNT(*) as total_bets'),
                                DB::raw('MAX(lotteries.created_at) as latest_bet_time')
                            )
                            ->groupBy('lottery_two_digit_pivot.two_digit_id')
                            ->first();

            $data[$digit->two_digit] = [
                'morning' => $morningData,
                'evening' => $eveningData,
            ];
        }

        return $data;
    }
 
 
 // public function getTwoDigitsData() {
    //     $twoDigits = TwoDigit::all();
    //     $morningStart = '06:00:00';
    //     $morningEnd = '12:00:00';
    //     $eveningStart = '12:00:00';
    //     $eveningEnd = '16:30:00';

    //     $data = [];
    //     foreach ($twoDigits as $digit) {
    //         $morningData = DB::table('lottery_two_digit_pivot')
    //                         ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
    //                         ->where('two_digit_id', $digit->id)
    //                         ->whereBetween(DB::raw('TIME(lotteries.created_at)'), [$morningStart, $morningEnd])
    //                         ->select('lottery_two_digit_pivot.*')
    //                         ->get();

    //         $eveningData = DB::table('lottery_two_digit_pivot')
    //                         ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
    //                         ->where('two_digit_id', $digit->id)
    //                         ->whereBetween(DB::raw('TIME(lotteries.created_at)'), [$eveningStart, $eveningEnd])
    //                         ->select('lottery_two_digit_pivot.*')
    //                         ->get();

    //         $data[$digit->two_digit] = [
    //             'morning' => $morningData,
    //             'evening' => $eveningData
    //         ];
    //     }

    //     return $data;
    // }
    //  public function getTwoDigitsData()
    // {
    //     // Define time ranges for morning and evening sessions
    //     $morningStart = '06:00:00';
    //     $morningEnd = '12:00:00';
    //     $eveningStart = '12:00:00';
    //     $eveningEnd = '16:30:00';

    //     // Get all two digits
    //     $twoDigits = TwoDigit::all();

    //     $data = [];
        
    //     foreach ($twoDigits as $digit) {
    //         // Fetch morning session data for each two-digit number
    //         $morningData = DB::table('lottery_two_digit_pivot')
    //                         ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
    //                         ->where('two_digit_id', $digit->id)
    //                         ->whereBetween(DB::raw('TIME(lotteries.created_at)'), [$morningStart, $morningEnd])
    //                         ->select(
    //                             'lottery_two_digit_pivot.two_digit_id',
    //                             DB::raw('SUM(lottery_two_digit_pivot.sub_amount) as total_sub_amount'),
    //                             DB::raw('GROUP_CONCAT(DISTINCT lottery_two_digit_pivot.bet_digit) as bet_digits'),
    //                             DB::raw('COUNT(*) as total_bets'),
    //                             DB::raw('MAX(lotteries.created_at) as latest_bet_time')
    //                         )
    //                         ->groupBy('lottery_two_digit_pivot.two_digit_id')
    //                         ->first();

    //         // Fetch evening session data for each two-digit number
    //         $eveningData = DB::table('lottery_two_digit_pivot')
    //                         ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
    //                         ->where('two_digit_id', $digit->id)
    //                         ->whereBetween(DB::raw('TIME(lotteries.created_at)'), [$eveningStart, $eveningEnd])
    //                         ->select(
    //                             'lottery_two_digit_pivot.two_digit_id',
    //                             DB::raw('SUM(lottery_two_digit_pivot.sub_amount) as total_sub_amount'),
    //                             DB::raw('GROUP_CONCAT(DISTINCT lottery_two_digit_pivot.bet_digit) as bet_digits'),
    //                             DB::raw('COUNT(*) as total_bets'),
    //                             DB::raw('MAX(lotteries.created_at) as latest_bet_time')
    //                         )
    //                         ->groupBy('lottery_two_digit_pivot.two_digit_id')
    //                         ->first();

    //         // Compile data for the current two-digit number
    //         $data[$digit->two_digit] = [
    //             'morning' => $morningData,
    //             'evening' => $eveningData,
    //         ];
    //     }

    //     return $data;
    // }

}