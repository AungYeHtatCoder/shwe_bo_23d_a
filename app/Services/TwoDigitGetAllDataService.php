<?php

namespace App\Services;

use App\Models\TwoD\Lottery;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TwoDigitGetAllDataService
{
    public function getAllTwoDigitData($timeRange = null)
    {
        $query = Lottery::with(['user', 'lotteryMatch', 'twoDigits' => function ($query) {
            $query->withPivot('sub_amount', 'prize_sent');
        }]);

        if ($timeRange === 'morning') {
            $startTime = Carbon::today()->setHour(6)->setMinute(0);
            $endTime = Carbon::today()->setHour(12)->setMinute(0);
        } elseif ($timeRange === 'evening') {
            $startTime = Carbon::today()->setHour(12)->setMinute(0);
            $endTime = Carbon::today()->setHour(16)->setMinute(0);
        }

        if (!empty($timeRange)) {
            $query->whereHas('twoDigits', function ($query) use ($startTime, $endTime) {
                $query->whereBetween('lottery_two_digit_pivot.created_at', [$startTime, $endTime]);
            });
        }

        $data = $query->get();

        return $data;
    }
}