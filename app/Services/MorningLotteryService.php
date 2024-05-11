<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MorningLotteryService
{
    /**
     * Get open lotteries for the current morning session on today's date.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOpenLotteriesForTodayMorning()
    {
        $today = Carbon::now(); // Get the current date and time
        $currentDate = $today->format('Y-m-d'); // Format to 'YYYY-MM-DD'
        
        // Retrieve data with the specified conditions
        return DB::table('lottery_two_digit_pivot')
            ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
            ->join('users', 'lotteries.user_id', '=', 'users.id')
            ->select(
                'users.name as user_name',
                'users.phone as user_phone',
                'lotteries.user_id', // User ID
                'lottery_two_digit_pivot.res_date', // Result date
                'lottery_two_digit_pivot.res_time', // Result time
                'lottery_two_digit_pivot.bet_digit', // Bet digit
                'lottery_two_digit_pivot.match_status', // Match status
                'lottery_two_digit_pivot.session', // Session (morning or evening)
                'lottery_two_digit_pivot.sub_amount' // Sub amount
            )
            ->where('lottery_two_digit_pivot.res_date', $currentDate) // Today's date
            ->where('lottery_two_digit_pivot.match_status', 'open') // Status is 'open'
            ->where('lottery_two_digit_pivot.session', 'morning') // Morning session
            ->get();
    }

    public function getTotalSubAmountForTodayMorning()
    {
        $today = Carbon::now(); // Get the current date and time
        $currentDate = $today->format('Y-m-d'); // Format to 'YYYY-MM-DD'

        // Get the total sub_amount for open lotteries in the current morning session
        return DB::table('lottery_two_digit_pivot')
            ->where('res_date', $currentDate) // Today's date
            ->where('match_status', 'open') // Status is 'open'
            ->where('session', 'morning') // Morning session
            ->sum('sub_amount'); // Calculate the total
    }
}