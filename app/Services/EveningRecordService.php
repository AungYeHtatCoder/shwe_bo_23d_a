<?php

namespace App\Services;

use App\Models\Lottery;
use App\Models\LotteryTwoDigitPivot;
use Carbon\Carbon;

class EveningRecordService
{
    public function EveningPlays($userId)
    {
        
        $currentTime = Carbon::now();
        $currentDate = Carbon::today();
        // Determine session based on current time
        $session = $this->getSession($currentTime);

        // Retrieve user's plays for the determined session
        $plays = Lottery::select('lotteries.*', 'lottery_two_digit_pivot.bet_digit', 'lottery_two_digit_pivot.sub_amount', 'users.name')
            ->join('lottery_two_digit_pivot', 'lotteries.id', '=', 'lottery_two_digit_pivot.lottery_id')
            ->join('users', 'lotteries.user_id', '=', 'users.id')
            ->where('lotteries.user_id', $userId)
            ->where('lotteries.session', $session)
             ->whereDate('lotteries.created_at', $currentDate)
            ->get();

        // Calculate the total sub_amount
        $totalSubAmount = $plays->sum('sub_amount');

        // Return plays along with the total sub_amount
        return [
            'plays' => $plays,
            'total_sub_amount' => $totalSubAmount,
        ];
    }

    private function getSession($time)
    {
        if ($time->hour >= 12 && $time->hour < 16) {
            return 'evening';
        } else {
            return 'no session record'; 
        }
    }
}