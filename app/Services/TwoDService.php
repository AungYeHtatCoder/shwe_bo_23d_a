<?php

namespace App\Services;

use App\Models\Lottery;
use App\Models\TwoD\TwoDigit;
use App\Models\TwoD\HeadDigit;
use App\Models\TwoD\TwoDLimit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\TwoD\LotteryTwoDigitPivot;

class TwoDService
{
    public function play($totalAmount, array $amounts)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();

            if ($user->balance < $totalAmount) {
                // throw new \Exception('Insufficient funds.');
                // return response()->json(['message' => 'လက်ကျန်ငွေ မလုံလောက်ပါ။'], 401);
                return "Insufficient funds.";
            }

            $preOver = [];
            foreach ($amounts as $amount) {
                $preCheck = $this->preProcessAmountCheck($amount);
                if(is_array($preCheck)){
                    $preOver[] = $preCheck[0];
                }
            }
            if(!empty($preOver)){
                return $preOver;
            }
    // Check if any selected digit starts with the head digits not allowed
     $headDigitsNotAllowed = HeadDigit::pluck('digit_one', 'digit_two', 'digit_three' )->toArray();
            foreach ($amounts as $amount) {
                $headDigitOfSelected = substr(sprintf('%02d', $amount['num']), 0, 1);
                if (in_array($headDigitOfSelected, $headDigitsNotAllowed)) {
                    return "Bets on numbers starting with '{$headDigitOfSelected}' are not allowed.";
                }
            }
    
            $lottery = Lottery::create([
                'pay_amount' => $totalAmount,
                'total_amount' => $totalAmount,
                'user_id' => $user->id,
                'session' => $this->determineSession(),
            ]);

            $over = [];
            foreach ($amounts as $amount) {
                $check = $this->processAmount($amount, $lottery->id);
                if(is_array($check)){
                    $over[] = $check[0];
                }
            }
            if(!empty($over)){
                return $over;
            }

            /** @var \App\Models\User $user */
            $user->balance -= $totalAmount;
            $user->save();

            DB::commit();

            // return ['message' => 'Bet placed successfully'];
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in TwoDService play method: ' . $e->getMessage());
            //return ['error' => $e->getMessage()];
            // Rethrow the exception to be handled by the global exception handler
            // 401 is the status code for Unauthorized
            return response()->json(['message'=> $e->getMessage()], 401);
        }
    }

     protected function preProcessAmountCheck($amount)
    {
        $twoDigit = TwoDigit::where('two_digit', sprintf('%02d', $amount['num']))->firstOrFail();
        $break = TwoDLimit::latest()->first()->two_d_limit;
        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
                                       ->where('two_digit_id', $twoDigit->id)
                                       ->sum('sub_amount');
        $subAmount = $amount['amount'];

        if ($totalBetAmountForTwoDigit + $subAmount > $break) {
            return [$amount['num']];
            // throw new \Exception('The bet amount exceeds the limit for two-digit number ' . $twoDigit->two_digit);
        }
    }

    protected function processAmount($amount, $lotteryId)
    {
        $twoDigit = TwoDigit::where('two_digit', sprintf('%02d', $amount['num']))->firstOrFail();

        $break = TwoDLimit::latest()->first()->two_d_limit;
        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
                                       ->where('two_digit_id', $twoDigit->id)
                                       ->sum('sub_amount');
        $subAmount = $amount['amount'];
        $betDigit = $amount['num'];

        if ($totalBetAmountForTwoDigit + $subAmount <= $break) {
            LotteryTwoDigitPivot::create([
                'lottery_id' => $lotteryId,
                'two_digit_id' => $twoDigit->id,
                'bet_digit' => $betDigit,
                'sub_amount' => $subAmount,
            ]);
        } else {
            // Handle the case where the bet exceeds the limit
            return [$amount['num']];
            // throw new \Exception('The bet amount exceeds the limit for two-digit number ' . $twoDigit->two_digit);
        }
    }

    private function determineSession()
    {
        return date('H') < 12 ? 'morning' : 'evening';
    }
}