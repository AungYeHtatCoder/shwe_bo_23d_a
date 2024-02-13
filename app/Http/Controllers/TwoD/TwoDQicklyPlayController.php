<?php

namespace App\Http\Controllers\TwoD;

use App\Models\TwoD\Lottery;
use Illuminate\Http\Request;
use App\Models\TwoD\TwoDigit;
use App\Models\Admin\LotteryMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TwoD\LotteryTwoDigitPivot;
use App\Models\TwoD\LotteryTwoDigitOverLimit;

class TwoDQicklyPlayController extends Controller
{
    public function quick_play_index()
    {
        $twoDigits = TwoDigit::all();

    // Calculate remaining amounts for each two-digit
    $remainingAmounts = [];
    foreach ($twoDigits as $digit) {
        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
            ->where('two_digit_id', $digit->id)
            ->sum('sub_amount');

        $remainingAmounts[$digit->id] = 1000000 - $totalBetAmountForTwoDigit; // Assuming 5000 is the session limit
    }
    $lottery_matches = LotteryMatch::where('id', 1)->whereNotNull('is_active')->first();

    return view('user.two_d.two_quick_play', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    }
    public function quick_play_confirm()
    {
        $twoDigits = TwoDigit::all();

    // Calculate remaining amounts for each two-digit
    $remainingAmounts = [];
    foreach ($twoDigits as $digit) {
        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
            ->where('two_digit_id', $digit->id)
            ->sum('sub_amount');

        $remainingAmounts[$digit->id] = 1000000 - $totalBetAmountForTwoDigit; // Assuming 5000 is the session limit
    }
    $lottery_matches = LotteryMatch::where('id', 1)->whereNotNull('is_active')->first();

    return view('user.two_d.two_d_quick_play_confirm', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    }
    public function store(Request $request)
{

    //Log::info($request->all());
    $validatedData = $request->validate([
        'selected_digits' => 'required|string',
        'amounts' => 'required|array',
        'amounts.*' => 'required|integer|min:100|max:1000000',
        //'totalAmount' => 'required|integer|min:100',
         'totalAmount' => 'required|numeric|min:100', // Changed from integer to numeric
        'user_id' => 'required|exists:users,id',
    ]);

    //$currentSession = date('H') < 12 ? 'morning' : 'evening';
    $currentTime = date('H:i');

    if ($currentTime >= '06:00' && $currentTime < '09:30') {
        $currentSession = 'early-morning';
    } elseif ($currentTime >= '09:30' && $currentTime < '12:00') {
        $currentSession = 'morning';
    } elseif ($currentTime >= '12:00' && $currentTime < '14:00') {
        $currentSession = 'early-evening';
    } else {
        $currentSession = 'evening';
    }
    $limitAmount = 1000000; // Define the limit amount

    DB::beginTransaction();

    try {
        $user = Auth::user();
        $user->balance -= $request->totalAmount;

        if ($user->balance < 0) {
            throw new \Exception('Insufficient balance.');
        }
        /** @var \App\Models\User $user */
        $user->save();

        $lottery = Lottery::create([
            'pay_amount' => $request->totalAmount,
            'total_amount' => $request->totalAmount,
            'user_id' => $request->user_id,
            'session' => $currentSession
        ]);

        foreach ($request->amounts as $two_digit_string => $sub_amount) {
            $two_digit_id = $two_digit_string === '00' ? 1 : intval($two_digit_string, 10) + 1;

            $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
                ->where('two_digit_id', $two_digit_id)
                ->sum('sub_amount');

            if ($totalBetAmountForTwoDigit + $sub_amount <= $limitAmount) {
                $pivot = new LotteryTwoDigitPivot([
                    'lottery_id' => $lottery->id,
                    'two_digit_id' => $two_digit_id,
                    'sub_amount' => $sub_amount,
                    'prize_sent' => false
                ]);
                $pivot->save();
            } else {
                $withinLimit = $limitAmount - $totalBetAmountForTwoDigit;
                $overLimit = $sub_amount - $withinLimit;

                if ($withinLimit > 0) {
                    $pivotWithin = new LotteryTwoDigitPivot([
                        'lottery_id' => $lottery->id,
                        'two_digit_id' => $two_digit_id,
                        'sub_amount' => $withinLimit,
                        'prize_sent' => false
                    ]);
                    $pivotWithin->save();
                }

                if ($overLimit > 0) {
                    $pivotOver = new LotteryTwoDigitOverLimit([
                        'lottery_id' => $lottery->id,
                        'two_digit_id' => $two_digit_id,
                        'sub_amount' => $overLimit,
                        'prize_sent' => false
                    ]);
                    $pivotOver->save();
                }
            }
        }

        DB::commit();
        session()->flash('SuccessRequest', 'Successfully placed bet.');
        return redirect()->route('home')->with('message', 'Data stored successfully!');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error in store method: ' . $e->getMessage());
        return redirect()->back()->with('error', $e->getMessage());
    }
}

}