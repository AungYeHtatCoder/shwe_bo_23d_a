<?php 

namespace App\Services;

use App\Models\ThreeDigit\Lotto;
use App\Models\Admin\ThreeDDLimit;
use App\Models\ThreeD\ThreeDLimit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ThreeDigit\ThreeDigit;
use App\Models\ThreeDigit\LotteryThreeDigitPivot;

class LottoService
{
    
     public function play($totalAmount, $amounts)
    {
        // Begin Transaction
        DB::beginTransaction();

        try {
            $user = Auth::user();

            if ($user->balance < $totalAmount) {
                // throw new \Exception('Insufficient balance.');
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

            //$lottery = $this->createLottery($totalAmount, $user->id);
            $lottery = Lotto::create([
                'total_amount' => $totalAmount,
                'user_id' => $user->id,
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

            $user->decrement('balance', $totalAmount);

            DB::commit();

            // return $lottery;
        } catch (\Exception $e) {
            DB::rollback();
            //throw $e;
             return response()->json(['message'=> $e->getMessage()], 401);
            //  return $e->getMessage();
        }
    }


    protected function preProcessAmountCheck($item)
{
    $num = str_pad($item['num'], 3, '0', STR_PAD_LEFT);
    $sub_amount = $item['amount'];
    $three_digit = ThreeDigit::where('three_digit', $num)->firstOrFail();
    $totalBetAmount = DB::table('lotto_three_digit_copy')->where('three_digit_id', $three_digit->id)->sum('sub_amount');
    $break = ThreeDLimit::latest()->first()->three_d_limit;

    if ($totalBetAmount + $sub_amount > $break) {
        // throw new \Exception("The bet amount for number $num exceeds the limit.");
        return [$item['num']];
    }
}

    protected function processAmount($item, $lotteryId)
    {
        $num = str_pad($item['num'], 3, '0', STR_PAD_LEFT);
        $sub_amount = $item['amount'];
        $bet_digit = $item['num'];

        // Find the corresponding three digit record
        $three_digit = ThreeDigit::where('three_digit', $num)->firstOrFail();

        // Calculate the total bet amount for the three_digit
        $totalBetAmount = DB::table('lotto_three_digit_copy')
                            ->where('three_digit_id', $three_digit->id)
                            ->sum('sub_amount');

        // Check if the limit is exceeded
        $break = ThreeDLimit::latest()->first()->three_d_limit;
        if ($totalBetAmount + $sub_amount <= $break) {
            // Create a pivot record for a valid bet
            $pivot = new LotteryThreeDigitPivot([
                'lotto_id' => $lotteryId,
                'three_digit_id' => $three_digit->id,
                'bet_digit' => $bet_digit,
                'sub_amount' => $sub_amount,
                'prize_sent' => false,
                'currency' => 'mmk'
            ]);
            $pivot->save();
        }else{
            return [$item['num']];
            // throw new \Exception('The bet amount exceeds the limit.');
            // return response()->json(['message'=> 'သတ်မှတ်ထားသော limit ပမာဏထပ်ကျော်လွန်နေပါသည်။'], 401);
        }
    }
}