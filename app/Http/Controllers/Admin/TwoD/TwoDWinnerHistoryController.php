<?php

namespace App\Http\Controllers\Admin\TwoD;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TwoDWinnerHistoryController extends Controller
{
    public function getWinners()
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        
            $winners = DB::table('lottery_two_digit_pivot')
    ->join('two_digits', 'lottery_two_digit_pivot.two_digit_id', '=', 'two_digits.id')
    ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
    ->join('users', 'lotteries.user_id', '=', 'users.id')
    ->join('twod_winers', 'two_digits.two_digit', '=', 'twod_winers.prize_no')
    ->whereDate('twod_winers.created_at', '>=', $oneMonthAgo)
    ->groupBy(
        'lotteries.user_id', 
        'twod_winers.session', 
        'users.name',
        'users.profile',
        'lottery_two_digit_pivot.sub_amount', // Add this
        'lotteries.total_amount', // And this
        'twod_winers.prize_no', // And this
        'twod_winers.created_at',  // Add this
    )
    ->select(
        'lotteries.user_id', 
        'twod_winers.session', 
        'users.name',
        'users.profile',
        'lottery_two_digit_pivot.sub_amount',
        'lotteries.total_amount',
         'twod_winers.prize_no', // Add this
        'twod_winers.created_at', // Add this
        DB::raw('lottery_two_digit_pivot.sub_amount * 85 as prize_amount')
    )
    ->get();

        return view('twod_winners_history', compact('winners'));
    }
    

    public function getWinnersHistoryForAdmin()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $winners = DB::table('lottery_two_digit_pivot')
        ->join('two_digits', 'lottery_two_digit_pivot.two_digit_id', '=', 'two_digits.id')
        ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
        ->join('users', 'lotteries.user_id', '=', 'users.id')
        ->join('twod_winers', 'two_digits.two_digit', '=', 'twod_winers.prize_no')
        ->whereDate('twod_winers.created_at', '>=', $oneMonthAgo)
        ->groupBy(
            'lotteries.user_id', 
            'twod_winers.session', 
            'users.name',
            'users.photo',
            'users.phone',
            'lottery_two_digit_pivot.sub_amount', 
            'lotteries.total_amount', 
            'twod_winers.prize_no', 
            'twod_winers.created_at',  
        )
        ->select(
            'lotteries.user_id', 
            'twod_winers.session', 
            'users.name',
            'users.photo',
            'users.phone',
            'lottery_two_digit_pivot.sub_amount',
            'lotteries.total_amount',
            'twod_winers.prize_no', 
            'twod_winers.created_at', 
            DB::raw('lottery_two_digit_pivot.sub_amount * 85 as prize_amount')
        )
        ->get();
    // Update the prize_sent date for each winner
     foreach ($winners as $winner) {
        $this->updatePrizeSentDate($winner->user_id); // Make sure user_id is the ID of the winner
    }

        return view('admin.two_d.winner_history', compact('winners'));
    }
    

    public function getWinnersHistoryForAdminGroupBySession()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $winners = DB::table('lottery_two_digit_pivot')
            ->join('two_digits', 'lottery_two_digit_pivot.two_digit_id', '=', 'two_digits.id')
            ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
            ->join('users', 'lotteries.user_id', '=', 'users.id')
            ->join('twod_winers', 'two_digits.two_digit', '=', 'twod_winers.prize_no')
            ->whereDate('twod_winers.created_at', '>=', $oneMonthAgo)
            ->groupBy(
            'lotteries.user_id', 
            'twod_winers.session', 
            'users.name',
            'users.photo',
            'users.phone',
            'lottery_two_digit_pivot.sub_amount', 
            'lotteries.total_amount', 
            'twod_winers.prize_no', 
            'twod_winers.created_at', 
            )
            ->select(
            'twod_winers.session', 
            'lotteries.user_id', 
            'users.name',
            'users.photo',
            'users.phone',
            'lottery_two_digit_pivot.sub_amount',
            'lotteries.total_amount',
            'twod_winers.prize_no', 
            'twod_winers.created_at',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(lottery_two_digit_pivot.sub_amount * 85) as total_prize_amount')
            )
            ->get();

        // Update the prize_sent date for each winner
        foreach ($winners as $winner) {
            $this->updatePrizeSentDate($winner->user_id); // Make sure user_id is the ID of the winner
        }

        return view('admin.two_d.winner_history_session', compact('winners'));
    }

    public function updatePrizeSentDate($winnerId)
    {
        $currentTime = Carbon::now()->format('H:i');
        $morningSessionEnd = Carbon::createFromTimeString('12:00')->format('H:i');
        $eveningSessionEnd = Carbon::createFromTimeString('16:30')->format('H:i');

        // Define the session based on the current time
        $session = ($currentTime <= $morningSessionEnd) ? 'morning' : (($currentTime <= $eveningSessionEnd) ? 'evening' : null);

        if ($session) {
            // Join with the lotteries table to access the session column
            DB::table('lottery_two_digit_pivot')
                ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
                ->where('lottery_two_digit_pivot.lottery_id', $winnerId)
                ->where('lotteries.session', $session)
                ->update(['prize_sent' => true]);

            return redirect()->back()->with('success', 'Prize sent date updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Record not found!');
        }
    }
    // public function updatePrizeSentDate($winnerId)
    // {
    //     // Find the lottery_two_digit_pivot record
    //     $lotteryTwoDigitPivot = DB::table('lottery_two_digit_pivot')->where('lottery_id', $winnerId)->first();

    //     // Check if the record exists
    //     if (!$lotteryTwoDigitPivot) {
    //         return redirect()->back()->with('error', 'Record not found!');
    //     }

    //     $currentTime = Carbon::now()->format('H:i');

    //     // Define the session times
    //    // $earlyMorningSessionEnd = Carbon::createFromTimeString('09:30')->format('H:i');
    //     $morningSessionEnd = Carbon::createFromTimeString('12:00')->format('H:i');
    //     //$earlyEveningSessionEnd = Carbon::createFromTimeString('14:00')->format('H:i');
    //     $eveningSessionEnd = Carbon::createFromTimeString('16:30')->format('H:i');

    //     // Check the current time and update the prize_sent field based on the session time
    //     if($currentTime <= $morningSessionEnd) {
    //         DB::table('lottery_two_digit_pivot')
    //             ->where('lottery_id', $winnerId)
    //             ->where('session', 'morning')
    //             ->update(['prize_sent' => true]);
    //     } elseif ($currentTime <= $eveningSessionEnd) {
    //         DB::table('lottery_two_digit_pivot')
    //             ->where('lottery_id', $winnerId)
    //             ->where('session', 'evening')
    //             ->update(['prize_sent' => true]);
    //     }else{
    //         return redirect()->back()->with('error', 'Record not found!');
    //     }
    //     // if ($currentTime <= $earlyMorningSessionEnd) {
    //     //     DB::table('lottery_two_digit_pivot')
    //     //         ->where('lottery_id', $winnerId)
    //     //         ->where('session', 'early-morning')
    //     //         ->update(['prize_sent' => true]);
    //     // } elseif ($currentTime <= $morningSessionEnd) {
    //     //     DB::table('lottery_two_digit_pivot')
    //     //         ->where('lottery_id', $winnerId)
    //     //         ->where('session', 'morning')
    //     //         ->update(['prize_sent' => true]);
    //     // } elseif ($currentTime <= $earlyEveningSessionEnd) {
    //     //     DB::table('lottery_two_digit_pivot')
    //     //         ->where('lottery_id', $winnerId)
    //     //         ->where('session', 'early-evening')
    //     //         ->update(['prize_sent' => true]);
    //     // } elseif ($currentTime <= $eveningSessionEnd) {
    //     //     DB::table('lottery_two_digit_pivot')
    //     //         ->where('lottery_id', $winnerId)
    //     //         ->where('session', 'evening')
    //     //         ->update(['prize_sent' => true]);
    //     // }

    //     return redirect()->back()->with('success', 'Prize sent date updated successfully!');
    // }

    public function getWinnersHistoryForAdminGroupBySessionApi()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $winners = DB::table('lottery_two_digit_pivot')
            ->join('two_digits', 'lottery_two_digit_pivot.two_digit_id', '=', 'two_digits.id')
            ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
            ->join('users', 'lotteries.user_id', '=', 'users.id')
            ->join('twod_winers', 'two_digits.two_digit', '=', 'twod_winers.prize_no')
            ->whereDate('twod_winers.created_at', '>=', $oneMonthAgo)
            ->groupBy(
            'lotteries.user_id', 
            'twod_winers.session', 
            'users.name',
            'users.profile',
            'users.phone',
            'lottery_two_digit_pivot.sub_amount', 
            'lotteries.total_amount', 
            'twod_winers.prize_no', 
            'twod_winers.created_at', 
            )
            ->select(
            'twod_winers.session', 
            'lotteries.user_id', 
            'users.name',
            'users.profile',
            'users.phone',
            'lottery_two_digit_pivot.sub_amount',
            'lotteries.total_amount',
            'twod_winers.prize_no', 
            'twod_winers.created_at',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(lottery_two_digit_pivot.sub_amount * 85) as prize_amount')
            )
            ->get();

        // Update the prize_sent date for each winner
        foreach ($winners as $winner) {
            $this->updatePrizeSentDateApi($winner->user_id); // Make sure user_id is the ID of the winner
        }

       return response()->json(['winners' => $winners], 200);
    }

     public function updatePrizeSentDateApi($winnerId)
    {
        $currentTime = Carbon::now()->format('H:i');
        $morningSessionEnd = Carbon::createFromTimeString('12:00')->format('H:i');
        $eveningSessionEnd = Carbon::createFromTimeString('16:30')->format('H:i');

        // Define the session based on the current time
        $session = ($currentTime <= $morningSessionEnd) ? 'morning' : (($currentTime <= $eveningSessionEnd) ? 'evening' : null);

        if ($session) {
            // Join with the lotteries table to access the session column
            DB::table('lottery_two_digit_pivot')
                ->join('lotteries', 'lottery_two_digit_pivot.lottery_id', '=', 'lotteries.id')
                ->where('lottery_two_digit_pivot.lottery_id', $winnerId)
                ->where('lotteries.session', $session)
                ->update(['prize_sent' => true]);

            return response()->json(['success' => 'Prize sent date updated successfully!'], 200);
        } else {
            return response()->json(['error' => 'Record not found!'], 404);
            
        }
    }

    // public function updatePrizeSentDateApi($winnerId)
    // {
    //     // Find the lottery_two_digit_pivot record
    //     $lotteryTwoDigitPivot = DB::table('lottery_two_digit_pivot')->where('lottery_id', $winnerId)->first();

    //     // Check if the record exists
    //     if (!$lotteryTwoDigitPivot) {
    //         return redirect()->back()->with('error', 'Record not found!');
    //     }

    //     $currentTime = Carbon::now()->format('H:i');

    //     // Define the session times
    //     $earlyMorningSessionEnd = Carbon::createFromTimeString('09:30')->format('H:i');
    //     $morningSessionEnd = Carbon::createFromTimeString('12:00')->format('H:i');
    //     $earlyEveningSessionEnd = Carbon::createFromTimeString('14:00')->format('H:i');
    //     $eveningSessionEnd = Carbon::createFromTimeString('16:30')->format('H:i');

    //     // Check the current time and update the prize_sent field based on the session time
    //     if ($currentTime <= $earlyMorningSessionEnd) {
    //         DB::table('lottery_two_digit_pivot')
    //             ->where('lottery_id', $winnerId)
    //             ->where('session', 'early-morning')
    //             ->update(['prize_sent' => true]);
    //     } elseif ($currentTime <= $morningSessionEnd) {
    //         DB::table('lottery_two_digit_pivot')
    //             ->where('lottery_id', $winnerId)
    //             ->where('session', 'morning')
    //             ->update(['prize_sent' => true]);
    //     } elseif ($currentTime <= $earlyEveningSessionEnd) {
    //         DB::table('lottery_two_digit_pivot')
    //             ->where('lottery_id', $winnerId)
    //             ->where('session', 'early-evening')
    //             ->update(['prize_sent' => true]);
    //     } elseif ($currentTime <= $eveningSessionEnd) {
    //         DB::table('lottery_two_digit_pivot')
    //             ->where('lottery_id', $winnerId)
    //             ->where('session', 'evening')
    //             ->update(['prize_sent' => true]);
    //     }

    //     return response()->json(['success' => 'Prize sent date updated successfully!'], 200);
    // }


}