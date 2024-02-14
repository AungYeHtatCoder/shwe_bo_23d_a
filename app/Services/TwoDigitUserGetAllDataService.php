<?php

namespace App\Services;

use App\Models\TwoD\Lottery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TwoDigitUserGetAllDataService
{
    // public function getUserTwoDigitData($timeRange = null)
    // {
    //     $userId = Auth::id();

    //     $query = Lottery::where('user_id', $userId)
    //                     ->with(['user', 'lotteryMatch', 'twoDigits' => function ($query) {
    //                         $query->withPivot('sub_amount', 'prize_sent');
    //                     }]);

    //     if ($timeRange === 'morning') {
    //         $startTime = Carbon::today()->setHour(6)->setMinute(0);
    //         $endTime = Carbon::today()->setHour(12)->setMinute(0);
    //     } elseif ($timeRange === 'evening') {
    //         $startTime = Carbon::today()->setHour(12)->setMinute(0);
    //         $endTime = Carbon::today()->setHour(16)->setMinute(0);
    //     }

    //     if (!empty($timeRange)) {
    //         $query->whereHas('twoDigits', function ($query) use ($startTime, $endTime) {
    //             $query->whereBetween('lottery_two_digit_pivot.created_at', [$startTime, $endTime]);
    //         });
    //     }

    //     $data = $query->get();

    //     // Calculate the total of all sub_amounts
    //     $totalSubAmount = $data->reduce(function ($carry, $lottery) {
    //         return $carry + $lottery->twoDigits->sum('pivot.sub_amount');
    //     }, 0);

    //     // Returning data along with the total sub_amount
    //     return [
    //         'data' => $data,
    //         'totalSubAmount' => $totalSubAmount,
    //     ];
    // }
    public function getUserTwoDigitData($timeRange = null)
    {
        // Retrieve the authenticated user's ID
        $userId = Auth::id();

        // Query only the lotteries associated with the authenticated user
        $query = Lottery::where('user_id', $userId)
                        ->with(['user', 'lotteryMatch', 'twoDigits' => function ($query) {
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

         // Calculate the total of all sub_amounts
        $totalSubAmount = $data->reduce(function ($carry, $lottery) {
            return $carry + $lottery->twoDigits->sum('pivot.sub_amount');
        }, 0);

        return [
            'data' => $data,
            'totalSubAmount' => $totalSubAmount,
        ];
    }
}