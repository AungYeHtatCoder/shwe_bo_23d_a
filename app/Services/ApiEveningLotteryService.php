<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApiEveningLotteryService
{
    /**
     * Get open lotteries for the current morning session on today's date.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAuthUserTodayEvening()
    {
        $authUser = Auth::user(); // Get the authenticated user
        $today = Carbon::now(); // Get the current date and time
        $currentDate = $today->format('Y-m-d'); // Format to 'YYYY-MM-DD'
        
        // Determine the current session (morning session between 4:00 am and 12:01 pm)
        $currentTime = $today->format('H:i:s');
        $isMorningSession = ($currentTime >= '12:1:00' && $currentTime <= '16:30:00');
        
        if (!$isMorningSession) {
            // If it's not morning session, return an empty collection
            return collect([]);
        }

        return DB::table('lottery_two_digit_pivot')
            ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id') // Join lotteries
            ->join('users', 'lotteries.user_id', '=', 'users.id') // Join users to access user details
            ->select(
                'users.name as user_name', // Get the user name
                'users.phone as user_phone', // Get the user phone
                'lottery_two_digit_pivot.res_date', // Result date
                'lottery_two_digit_pivot.res_time', // Result time
                'lottery_two_digit_pivot.bet_digit', // Bet digit
                'lottery_two_digit_pivot.match_status', // Match status
                'lottery_two_digit_pivot.session', // Session
                'lottery_two_digit_pivot.sub_amount' // Sub amount
            )
            ->where('lottery_two_digit_pivot.res_date', $currentDate) // Today's date
            ->where('lottery_two_digit_pivot.match_status', 'open') // Status is 'open'
            ->where('lottery_two_digit_pivot.session', 'evening') // evening session
            ->where('lotteries.user_id', $authUser->id) // Authenticated user
            ->get(); // Return the collection

    }


    public function TotalSubAmountForTodayEvening()
    {
        $authUser = Auth::user(); // Get the authenticated user
        $today = Carbon::now(); // Get the current date and time
        $currentDate = $today->format('Y-m-d'); // Format to 'YYYY-MM-DD'
        
        return DB::table('lottery_two_digit_pivot')
            ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id') // Fix: Join lotteries to access user_id
            ->where('lottery_two_digit_pivot.res_date', $currentDate) // Today's date
            ->where('lottery_two_digit_pivot.match_status', 'open') // Status is 'open'
            ->where('lottery_two_digit_pivot.session', 'evening') // evening session
            ->where('lotteries.user_id', $authUser->id) // Authenticated user ID
            ->sum('lottery_two_digit_pivot.sub_amount'); // Calculate the total sub_amount
    }
}