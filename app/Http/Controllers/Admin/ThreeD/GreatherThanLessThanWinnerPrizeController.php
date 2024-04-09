<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ThreeDigit\Prize;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GreatherThanLessThanWinnerPrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $three_digits_prize = Prize::orderBy('id', 'desc')->first();
        return view('admin.three_d.g_l_prize_index', compact('three_digits_prize'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    //$currentSession = date('H') < 12 ? 'morning' : 'evening';  // before 1 pm is morning

        Prize::create([
            'prize_one' => $request->prize_one,
            'prize_two' => $request->prize_two,
            //'session' => $currentSession,
        ]);
        session()->flash('SuccessRequest', 'Three Digit Lottery Prize Number Created Successfully');

        return redirect()->back()->with('success', 'Three Digit Lottery Prize Number Created Successfully');
    }
    public function destroy(string $id)
    {
        $digit = Prize::find($id);
        $digit->delete();
        session()->flash('SuccessRequest', 'Three Digit Lottery Prize Number Deleted Successfully');
        return redirect()->back()->with('success', 'Three Digit Lottery Prize Number Deleted Successfully');
    }

    public function getPrizeWinnersHistoryForAdmin()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $winners = DB::table('lotto_three_digit_copy')
        ->join('three_digits', 'lotto_three_digit_copy.three_digit_id', '=', 'three_digits.id')
        ->join('lottos', 'lotto_three_digit_copy.lotto_id', '=', 'lottos.id')
        ->join('users', 'lottos.user_id', '=', 'users.id')
        ->join('three_winners', 'three_digits.three_digit', '=', 'three_winners.prize_no')
        ->whereDate('three_winners.created_at', '>=', $oneMonthAgo)
        ->groupBy(
            'lottos.user_id', 
            'users.name',
            'users.profile',
            'users.phone',
            'lotto_three_digit_copy.sub_amount', 
            'lotto_three_digit_copy.prize_sent',
            'lottos.total_amount', 
            'three_winners.prize_no', 
            'three_winners.created_at',  
        )
        ->select(
            'lottos.user_id', 
            'users.name',
            'users.profile',
            'users.phone',
            'lotto_three_digit_copy.sub_amount',
            'lotto_three_digit_copy.prize_sent',
            'lottos.total_amount',
            'three_winners.prize_no', 
            'three_winners.created_at', 
         DB::raw('lotto_three_digit_copy.sub_amount * 10 as prize_amount')
        )
        ->orderBy('prize_amount', 'desc') // Add this line to sort by prize_amount in descending order
        ->get();
    // Update the prize_sent date for each winner
     foreach ($winners as $winner) {
        $this->updatePermutationPrizeSentDate($winner->user_id); // Make sure user_id is the ID of the winner
    }

        return view('admin.three_d.prize_winner_history', compact('winners'));
    }

     public function updatePermutationPrizeSentDate($winnerId)
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