<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\TwoD\Lottery;

class TwoDigitGetAllDataService
{
    public function getAllTwoDigitData($timeRange = null)
    {
        // Start date set to one month ago from today
        $startDate = Carbon::now()->subMonth()->startOfDay();
        // End date set to today's date for end of the day
        $endDate = Carbon::now()->endOfDay();

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

        // Adjust the query to filter by the created_at date being within the last month
        $query->whereBetween('created_at', [$startDate, $endDate]);

        if (!empty($timeRange)) {
            // Apply additional filtering based on time range if specified
            $query->whereHas('twoDigits', function ($query) use ($startTime, $endTime) {
                $query->whereBetween('lottery_two_digit_pivot.created_at', [$startTime, $endTime]);
            });
        }

        $data = $query->get();

        return $data;
    }
}