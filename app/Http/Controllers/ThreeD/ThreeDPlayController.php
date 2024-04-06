<?php

namespace App\Http\Controllers\ThreeD;

use App\Models\User;
use App\Models\ThreeD\Lotto;
use Illuminate\Http\Request;
use App\Models\ThreeD\ThreeDigit;
use App\Models\Admin\LotteryMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ThreeDigit\ThreeDigitOverLimit;
use App\Models\ThreeDigit\LotteryThreeDigitPivot;

class ThreeDPlayController extends Controller
{
    public function index()
    {
        return view('user.three_d.index');
    }
    // threed play
    public function choiceplay()
    {
        $threeDigits = ThreeDigit::all();

    // Calculate remaining amounts for each two-digit
    $remainingAmounts = [];
    foreach ($threeDigits as $digit) {
        $totalBetAmountForTwoDigit = DB::table('lotto_three_digit_pivot')
            ->where('three_digit_id', $digit->id)
            ->sum('sub_amount');

        $remainingAmounts[$digit->id] = 50000 - $totalBetAmountForTwoDigit; // Assuming 5000 is the session limit
    }
    $lottery_matches = LotteryMatch::where('id', 2)->whereNotNull('is_active')->first();

    return view('user.three_d.three_d_choice_play', compact('threeDigits', 'remainingAmounts', 'lottery_matches'));
        //return view('three_d.three_d_choice_play');
    }
    public function confirm_play()
    {
        $threeDigits = ThreeDigit::all();

    // Calculate remaining amounts for each two-digit
    $remainingAmounts = [];
    foreach ($threeDigits as $digit) {
        $totalBetAmountForTwoDigit = DB::table('lotto_three_digit_pivot')
            ->where('three_digit_id', $digit->id)
            ->sum('sub_amount');

        $remainingAmounts[$digit->id] = 50000 - $totalBetAmountForTwoDigit; // Assuming 5000 is the session limit
    }
    $lottery_matches = LotteryMatch::where('id', 2)->whereNotNull('is_active')->first();

    return view('user.three_d.play_confirm', compact('threeDigits', 'remainingAmounts', 'lottery_matches'));
        //return view('three_d.three_d_choice_play');
    }

    public function user_play()
    {
        $userId = auth()->id(); // Get logged in user's ID
        
        $displayThreeDigits = User::getUserThreeDigits($userId);
        return view('user.three_d.three_d_display', [
            'displayThreeDigits' => $displayThreeDigits,
        ]);
    }


    public function store(Request $request)
{
    
    //Log::info($request->all());
    $validatedData = $request->validate([
        'selected_digits' => 'required|string',
        'amounts' => 'required|array',
        'amounts.*' => 'required|integer|min:100|max:50000',
        'totalAmount' => 'required|numeric|min:100', 
        'user_id' => 'required|exists:users,id',
    ]);

    //$currentSession = date('H') < 12 ? 'morning' : 'evening';
    $limitAmount = 50000; // Define the limit amount

    DB::beginTransaction();

    try {
        $user = Auth::user();
        $user->balance -= $request->totalAmount;

        if ($user->balance < 0) {
            throw new \Exception('Insufficient balance.');
        }
        
        /** @var \App\Models\User $user */

        $user->save();

        $lottery = Lotto::create([
            //'pay_amount' => $request->totalAmount,
            'total_amount' => $request->totalAmount,
            'user_id' => $request->user_id,
            //'session' => $currentSession
        ]);

        foreach ($request->amounts as $three_digit_string => $sub_amount) {
            $three_digit_id = $three_digit_string === '00' ? 1 : intval($three_digit_string, 10) + 1;

            $totalBetAmountForTwoDigit = DB::table('lotto_three_digit_copy')
                ->where('three_digit_id', $three_digit_id)
                ->sum('sub_amount');

            if ($totalBetAmountForTwoDigit + $sub_amount <= $limitAmount) {
                $pivot = new LotteryThreeDigitPivot([
                    'lotto_id' => $lottery->id,
                    'three_digit_id' => $three_digit_id,
                    'bet_digit' => $three_digit_string, // Added 'bet_digit' to the pivot table
                    'sub_amount' => $sub_amount,
                    'prize_sent' => false
                ]);
                $pivot->save();
            } else {
                $withinLimit = $limitAmount - $totalBetAmountForTwoDigit;
                $overLimit = $sub_amount - $withinLimit;

                if ($withinLimit > 0) {
                    $pivotWithin = new LotteryThreeDigitPivot([
                        'lotto_id' => $lottery->id,
                        'three_digit_id' => $three_digit_id,
                        'sub_amount' => $withinLimit,
                        'prize_sent' => false
                    ]);
                    $pivotWithin->save();
                }

                if ($overLimit > 0) {
                    $pivotOver = new ThreeDigitOverLimit([
                        'lottery_id' => $lottery->id,
                        'two_digit_id' => $three_digit_id,
                        'sub_amount' => $overLimit,
                        'prize_sent' => false
                    ]);
                    $pivotOver->save();
                }
            }
        }

        DB::commit();
        session()->flash('SuccessRequest', 'Successfully placed bet.');
        return redirect()->route('user.display')->with('message', 'Data stored successfully!');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error in store method: ' . $e->getMessage());
        return redirect()->back()->with('error', $e->getMessage());
    }
}


    
}