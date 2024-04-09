<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ThreeDigit\Lotto;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ThreeDigit\ThreeWinner;

class ThreeDWinnerController extends Controller
{
    public function index()
    {
        $lotteries = Lotto::with('threedDigitWinner')->get();

        $prize_no_morning = ThreeWinner::whereDate('created_at', Carbon::today())
                                     ->whereBetween('created_at', [Carbon::now()->startOfDay()->addHours(10), Carbon::now()->startOfDay()->addHours(24)])
                                     ->orderBy('id', 'desc')
                                     ->first();
       
                                     $prize_no = ThreeWinner::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
        return view('admin.three_d.three_d_winner', compact('lotteries', 'prize_no_morning', 'prize_no'));
    }


    public function getWinnersHistoryForAdmin()
    {
        $oneMonthAgo = Carbon::now()->subMonths(5);
        $winners = DB::table('lotto_three_digit_pivot')
        ->join('three_digits', 'lotto_three_digit_pivot.three_digit_id', '=', 'three_digits.id')
        ->join('lottos', 'lotto_three_digit_pivot.lotto_id', '=', 'lottos.id')
        ->join('users', 'lottos.user_id', '=', 'users.id')
        ->join('three_winners', 'three_digits.three_digit', '=', 'three_winners.prize_no')
        ->whereDate('three_winners.created_at', '>=', $oneMonthAgo)
        ->groupBy(
            'lottos.user_id', 
            'users.name',
            'users.photo',
            'users.phone',
            'lotto_three_digit_pivot.sub_amount', 
            'lotto_three_digit_pivot.prize_sent',
            'lottos.total_amount', 
            'three_winners.prize_no', 
            'three_winners.created_at',  
        )
        ->select(
            'lottos.user_id', 
            'users.name',
            'users.photo',
            'users.phone',
            'lotto_three_digit_pivot.sub_amount',
            'lotto_three_digit_pivot.prize_sent',
            'lottos.total_amount',
            'three_winners.prize_no', 
            'three_winners.created_at', 
         DB::raw('lotto_three_digit_pivot.sub_amount * 600 as prize_amount')
        )
        ->orderBy('prize_amount', 'desc') // Add this line to sort by prize_amount in descending order
        ->get();
    // Update the prize_sent date for each winner
     foreach ($winners as $winner) {
        //$this->updatePrizeSentDate($winner->user_id); // Make sure user_id is the ID of the winner
        $winner->user_id;
    }

        return view('admin.three_d.three_d_winner_history', compact('winners'));
    }

    public function getPermutationWinnersHistoryForAdmin()
    {
        $oneMonthAgo = Carbon::now()->subMonths(5);
        $winners = DB::table('lotto_three_digit_pivot')
        ->join('three_digits', 'lotto_three_digit_pivot.three_digit_id', '=', 'three_digits.id')
        ->join('lottos', 'lotto_three_digit_pivot.lotto_id', '=', 'lottos.id')
        ->join('users', 'lottos.user_id', '=', 'users.id')
        ->join('permutations', 'three_digits.three_digit', '=', 'permutations.digit')
        ->whereDate('permutations.created_at', '>=', $oneMonthAgo)
        ->groupBy(
            'lottos.user_id', 
            'users.name',
            'users.photo',
            'users.phone',
            'lotto_three_digit_pivot.sub_amount', 
            'lotto_three_digit_pivot.prize_sent',
            'lottos.total_amount', 
            'permutations.digit', 
            'permutations.created_at',  
        )
        ->select(
            'lottos.user_id', 
            'users.name',
            'users.photo',
            'users.phone',
            'lotto_three_digit_pivot.sub_amount',
            'lotto_three_digit_pivot.prize_sent',
            'lottos.total_amount',
            'permutations.digit', 
            'permutations.created_at', 
         DB::raw('lotto_three_digit_pivot.sub_amount * 10 as prize_amount')
        )
        ->orderBy('prize_amount', 'desc') // Add this line to sort by prize_amount in descending order
        ->get();
    // Update the prize_sent date for each winner
     foreach ($winners as $winner) {
        //$this->updatePermutationPrizeSentDate($winner->user_id); // Make sure user_id is the ID of the winner
        $winner->user_id;
    }

        return view('admin.three_d.three_d_permutation_winner_history', compact('winners'));
    }

    // public function getPermutationWinnersHistoryForAdmin()
    // {
    //     $oneMonthAgo = Carbon::now()->subMonth();
    //     $winners = DB::table('lotto_three_digit_pivot')
    //     ->join('three_digits', 'lotto_three_digit_pivot.three_digit_id', '=', 'three_digits.id')
    //     ->join('lottos', 'lotto_three_digit_pivot.lotto_id', '=', 'lottos.id')
    //     ->join('users', 'lottos.user_id', '=', 'users.id')
    //     ->join('three_winners', 'three_digits.three_digit', '=', 'three_winners.prize_no')
    //     ->whereDate('three_winners.created_at', '>=', $oneMonthAgo)
    //     ->groupBy(
    //         'lottos.user_id', 
    //         'users.name',
    //         'users.profile',
    //         'users.phone',
    //         'lotto_three_digit_pivot.sub_amount', 
    //         'lotto_three_digit_pivot.prize_sent',
    //         'lottos.total_amount', 
    //         'three_winners.prize_no', 
    //         'three_winners.created_at',  
    //     )
    //     ->select(
    //         'lottos.user_id', 
    //         'users.name',
    //         'users.profile',
    //         'users.phone',
    //         'lotto_three_digit_pivot.sub_amount',
    //         'lotto_three_digit_pivot.prize_sent',
    //         'lottos.total_amount',
    //         'three_winners.prize_no', 
    //         'three_winners.created_at', 
    //      DB::raw('lotto_three_digit_pivot.sub_amount * 10 as prize_amount')
    //     )
    //     ->orderBy('prize_amount', 'desc') // Add this line to sort by prize_amount in descending order
    //     ->get();
    // // Update the prize_sent date for each winner
    //  foreach ($winners as $winner) {
    //     $this->updatePermutationPrizeSentDate($winner->user_id); // Make sure user_id is the ID of the winner
    // }

    //     return view('admin.three_d.three_d_permutation_winner_history', compact('winners'));
    // }

     public function updatePrizeSentDate($winnerId)
    {
        // Find the lottery_two_digit_pivot record
        $lotteryTwoDigitPivot = DB::table('lotto_three_digit_pivot')->where('lotto_id', $winnerId)->first();

        // Check if the record exists
        if (!$lotteryTwoDigitPivot) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        // Update the prize_sent field to true
        DB::table('lotto_three_digit_pivot')
            ->where('lotto_id', $winnerId)
            ->update(['prize_sent' => true]);

        return redirect()->back()->with('success', 'Prize sent date updated successfully!');
    }

    public function updatePermutationPrizeSentDate($winnerId)
    {
        // Find the lottery_two_digit_pivot record
        $lotteryTwoDigitPivot = DB::table('lotto_three_digit_pivot')->where('lotto_id', $winnerId)->first();

        // Check if the record exists
        if (!$lotteryTwoDigitPivot) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        // Update the prize_sent field to true
        DB::table('lotto_three_digit_pivot')
            ->where('lotto_id', $winnerId)
            ->update(['prize_sent' => 2]);

        return redirect()->back()->with('success', 'Prize sent date updated successfully!');
    }

    public function getWinnersHistoryForAdminApi()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $winners = DB::table('lotto_three_digit_pivot')
        ->join('three_digits', 'lotto_three_digit_pivot.three_digit_id', '=', 'three_digits.id')
        ->join('lottos', 'lotto_three_digit_pivot.lotto_id', '=', 'lottos.id')
        ->join('users', 'lottos.user_id', '=', 'users.id')
        ->join('three_winners', 'three_digits.three_digit', '=', 'three_winners.prize_no')
        ->whereDate('three_winners.created_at', '>=', $oneMonthAgo)
        ->groupBy(
            'lottos.user_id', 
            'users.name',
            'users.profile',
            'users.phone',
            'lotto_three_digit_pivot.sub_amount', 
            'lotto_three_digit_pivot.prize_sent',
            'lottos.total_amount', 
            'three_winners.prize_no', 
            'three_winners.created_at',  
        )
        ->select(
            'lottos.user_id', 
            'users.name',
            'users.profile',
            'users.phone',
            'lotto_three_digit_pivot.sub_amount',
            'lotto_three_digit_pivot.prize_sent',
            'lottos.total_amount',
            'three_winners.prize_no', 
            'three_winners.created_at', 
         DB::raw('lotto_three_digit_pivot.sub_amount * 600 as prize_amount')
        )
        ->orderBy('prize_amount', 'desc') // Add this line to sort by prize_amount in descending order
        ->get();
    // Update the prize_sent date for each winner
     foreach ($winners as $winner) {
       // $this->updatePrizeSentDateApi($winner->user_id); // Make sure user_id is the ID of the winner
       $winner->user_id;
    }

         return response()->json(['winners' => $winners], 200);
    }

     public function updatePrizeSentDateApi($winnerId)
    {
        // Find the lottery_two_digit_pivot record
        $lotteryTwoDigitPivot = DB::table('lotto_three_digit_pivot')->where('lotto_id', $winnerId)->first();

        // Check if the record exists
        if (!$lotteryTwoDigitPivot) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        // Update the prize_sent field to true
        DB::table('lotto_three_digit_pivot')
            ->where('lotto_id', $winnerId)
            ->update(['prize_sent' => true]);

       return response()->json(['success' => 'Prize sent date updated successfully!'], 200);
    }

    public function getPrizeWinnersHistoryForAdmin()
{
    $oneMAgo = Carbon::now()->subMonth();

    $winners = DB::table('lotto_three_digit_copy')
        ->join('three_digits', 'lotto_three_digit_copy.three_digit_id', '=', 'three_digits.id')
        ->join('lottos', 'lotto_three_digit_copy.lotto_id', '=', 'lottos.id')
        ->join('users', 'lottos.user_id', '=', 'users.id')
        ->join('prizes', function ($join) {
            $join->on('three_digits.three_digit', '=', 'prizes.prize_one')
                ->orOn('three_digits.three_digit', '=', 'prizes.prize_two');
        })
        ->whereDate('prizes.created_at', '>=', $oneMAgo)
        ->groupBy(
            'lottos.user_id',
            'users.name',
            'users.photo',
            'users.phone',
            'lotto_three_digit_copy.sub_amount',
            'lotto_three_digit_copy.prize_sent',
            'lottos.total_amount',
            'prizes.prize_one',
            'prizes.prize_two',
            'prizes.created_at',
        )
        ->select(
            'lottos.user_id',
            'users.name',
            'users.photo',
            'users.phone',
            'lotto_three_digit_copy.sub_amount',
            'lotto_three_digit_copy.prize_sent',
            'lottos.total_amount',
            'prizes.prize_one',
            'prizes.prize_two',
            'prizes.created_at',
            DB::raw('lotto_three_digit_copy.sub_amount * 10 as prize_amount'),
            DB::raw('lotto_three_digit_copy.sub_amount * 10 as winner_amount')
        )
        ->orderBy('prize_amount', 'desc')
        ->get();

    // Update the prize_sent date for each winner
    foreach ($winners as $winner) {
        //$this->updateGreatePrizeSentDate($winner->user_id); // Make sure user_id is the ID of the winner
        $winner->user_id;
    }

    return view('admin.three_d.prize_winner_history', compact('winners'));
}


    // public function getPrizeWinnersHistoryForAdmin()
    // {
    //     $oneMonthAgo = Carbon::now()->subMonth();
    //     $winners = DB::table('lotto_three_digit_copy')
    //     ->join('three_digits', 'lotto_three_digit_copy.three_digit_id', '=', 'three_digits.id')
    //     ->join('lottos', 'lotto_three_digit_copy.lotto_id', '=', 'lottos.id')
    //     ->join('users', 'lottos.user_id', '=', 'users.id')
    //     ->join('three_winners', 'three_digits.three_digit', '=', 'three_winners.prize_no')
    //     ->whereDate('three_winners.created_at', '>=', $oneMonthAgo)
    //     ->groupBy(
    //         'lottos.user_id', 
    //         'users.name',
    //         'users.profile',
    //         'users.phone',
    //         'lotto_three_digit_copy.sub_amount', 
    //         'lotto_three_digit_copy.prize_sent',
    //         'lottos.total_amount', 
    //         'three_winners.prize_no', 
    //         'three_winners.created_at',  
    //     )
    //     ->select(
    //         'lottos.user_id', 
    //         'users.name',
    //         'users.profile',
    //         'users.phone',
    //         'lotto_three_digit_copy.sub_amount',
    //         'lotto_three_digit_copy.prize_sent',
    //         'lottos.total_amount',
    //         'three_winners.prize_no', 
    //         'three_winners.created_at', 
    //      DB::raw('lotto_three_digit_copy.sub_amount * 10 as prize_amount')
    //     )
    //     ->orderBy('prize_amount', 'desc') // Add this line to sort by prize_amount in descending order
    //     ->get();
    // // Update the prize_sent date for each winner
    //  foreach ($winners as $winner) {
    //     $this->updateGreatePrizeSentDate($winner->user_id); // Make sure user_id is the ID of the winner
    // }

    //     return view('admin.three_d.prize_winner_history', compact('winners'));
    // }

     public function updateGreatePrizeSentDate($winnerId)
    {
        // Find the lottery_two_digit_pivot record
        $lotteryTwoDigitPivot = DB::table('lotto_three_digit_copy')->where('lotto_id', $winnerId)->first();

        // Check if the record exists
        if (!$lotteryTwoDigitPivot) {
            return redirect()->back()->with('error', 'Record not found!');
        }

        // Update the prize_sent field to true
        DB::table('lotto_three_digit_copy')
            ->where('lotto_id', $winnerId)
            ->update(['prize_sent' => 3]);

        return redirect()->back()->with('success', 'Prize sent date updated successfully!');
    }


}