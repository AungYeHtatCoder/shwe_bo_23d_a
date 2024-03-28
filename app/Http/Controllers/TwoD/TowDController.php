<?php

namespace App\Http\Controllers\TwoD;

use App\Models\RoleLimit;
use App\Models\TwoD\Lottery;
use Illuminate\Http\Request;
use App\Models\TwoD\TwoDigit;
use App\Models\TwoD\HeadDigit;
use App\Models\TwoD\TwoDLimit;
use App\Models\Admin\LotteryMatch;
use App\Models\TwoD\CloseTwoDigit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TwoD\LotteryTwoDigitPivot;
use App\Models\TwoD\LotteryTwoDigitOverLimit;

class TowDController extends Controller
{
    public function index()
    {
        return view('user.two_d.play_index');
    }
    // 12 pm two d play index
    public function twelvepm()
    {
        $twoDigits = TwoDigit::all();

    $remainingAmounts = [];
    foreach ($twoDigits as $digit) {
        $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
            ->where('two_digit_id', $digit->id)
            ->sum('sub_amount');

        $remainingAmounts[$digit->id] = 1000000 - $totalBetAmountForTwoDigit; // Assuming 5000 is the session limit
    }
    $lottery_matches = LotteryMatch::where('id', 1)->whereNotNull('is_active')->first();

    return view('user.two_d.12_pm.index', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    }

    public function play_confirm()
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

    return view('user.two_d.12_pm.play_confirm', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    }
    // 4:30 pm two d play index
    public function fourpm()
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

    return view('user.two_d.4_pm.index', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    }

    public function play_confirm4pm()
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
    return view('user.two_d.4_pm.play_confirm', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    }
    // 12 pm two d play 
    public function store(Request $request)
    {
    Log::info($request->all());
    $validatedData = $request->validate([
        'selected_digits' => 'required|string',
        'amounts' => 'required|array',
        'amounts.*' => 'required|integer|min:1',
        'totalAmount' => 'required|numeric|min:1',
        'user_id' => 'required|exists:users,id',
    ]);

    $headDigitsNotAllowed = HeadDigit::pluck('digit_one', 'digit_two', 'digit_three')->flatten()->unique()->toArray();
    foreach ($request->amounts as $two_digit_string => $sub_amount) {
        $headDigitOfSelected = substr($two_digit_string, 0, 1); // Extract the head digit
        if (in_array($headDigitOfSelected, $headDigitsNotAllowed)) {
            return redirect()->back()->with('error', "Bets on numbers starting with '{$headDigitOfSelected}' are not allowed.");
        }
    }
    $closedTwoDigits = CloseTwoDigit::pluck('digit')->map(function ($digit) {
    // Ensure formatting as a two-digit string
    return sprintf('%02d', $digit);
    })->toArray();

    $errors = [];
    foreach ($request->input('amounts') as $key => $value) {
        // Assuming the structure is ['digit' => amount], directly use the key from the array
        $twoDigitOfSelected = sprintf('%02d', $key);
        if (in_array($twoDigitOfSelected, $closedTwoDigits)) {
            $errors[] = "Bets on number '{$twoDigitOfSelected}' are not allowed.";
        }
    }

    if (!empty($errors)) {
        $errorMessage = implode(' ', $errors);
        return redirect()->back()->with('error', $errorMessage);
    }

    $currentSession = $this->determineSession();
    $user = Auth::user();
    $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;    
    $userRole = $user->roles()->first();
    $roleLimitAmount = optional(RoleLimit::where('role_id', $userRole->id)->first())->limit ?? $defaultLimitAmount;
    $limitAmount = max($defaultLimitAmount, $roleLimitAmount);
    DB::beginTransaction();
    try {
        $user->decrement('balance', $request->totalAmount);

        $lottery = Lottery::create([
            'pay_amount' => $request->totalAmount,
            'total_amount' => $request->totalAmount,
            'user_id' => $user->id,
            'session' => $currentSession,
        ]);
        foreach ($request->amounts as $two_digit_string => $sub_amount) {
            $this->processBet($two_digit_string, $sub_amount, $limitAmount, $lottery);
        }
        DB::commit();
        session()->flash('SuccessRequest', 'Successfully placed bet.');
        return redirect()->route('user.two-digit-user-data.morning')->with('success', 'အောင်မြင်ပါသည်။');
        //return redirect()->back()->with('message', 'Bet placed successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error in store method: ' . $e->getMessage());
        return redirect()->back()->with('error', $e->getMessage());
    }
    }
    // 4:30 pm two d play
    public function store4pm(Request $request)
    {
        //dd($request->all());
        //Log::info($request->all());
        $validatedData = $request->validate([
            'selected_digits' => 'required|string',
            'amounts' => 'required|array',
            'amounts.*' => 'required|integer|min:1',
            'totalAmount' => 'required|numeric|min:1',
            'user_id' => 'required|exists:users,id',
        ]);

         $headDigitsNotAllowed = HeadDigit::pluck('digit_one', 'digit_two', 'digit_three')->flatten()->unique()->toArray();

    foreach ($request->amounts as $two_digit_string => $sub_amount) {
        $headDigitOfSelected = substr($two_digit_string, 0, 1); // Extract the head digit
        if (in_array($headDigitOfSelected, $headDigitsNotAllowed)) {
            return redirect()->back()->with('error', "Bets on numbers starting with '{$headDigitOfSelected}' are not allowed.");
        }
    }
            $closedDigits = CloseTwoDigit::all()->pluck('digit')->map(function ($digit) {
                return sprintf('%02d', $digit);
            })->toArray();

    // Iterate over submitted bets
    foreach ($request->input('amounts') as $bet) {
        $betDigit = sprintf('%02d', $bet['num']); // Format the bet number

        // Check if the bet is on a closed digit
        if (in_array($betDigit, $closedDigits)) {
            return redirect()->back()->with('error', "Bets on number '{$betDigit}' are not allowed.");
        }
    }
        $currentSession = $this->determineSession();
        $user = Auth::user();
        $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;
        $userRole = $user->roles()->first();
        $roleLimitAmount = optional(RoleLimit::where('role_id', $userRole->id)->first())->limit ?? $defaultLimitAmount;
        $limitAmount = max($defaultLimitAmount, $roleLimitAmount);
        DB::beginTransaction();
        try {
            $user->decrement('balance', $request->totalAmount);

            $lottery = Lottery::create([
                'pay_amount' => $request->totalAmount,
                'total_amount' => $request->totalAmount,
                'user_id' => $user->id,
                'session' => $currentSession,
            ]);

            foreach ($request->amounts as $two_digit_string => $sub_amount) {
                $this->processBet($two_digit_string, $sub_amount, $limitAmount, $lottery);
            }

            DB::commit();
            session()->flash('SuccessRequest', 'Successfully placed bet.');
            return redirect()->route('user.two-digit-user-data.afternoon')->with('success', 'အောင်မြင်ပါသည်။');
            //return redirect()->back()->with('message', 'Bet placed successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in store method: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    private function determineSession()
    {
        $currentTime = date('H:i');
        return ($currentTime >= '06:00' && $currentTime < '12:00') ? 'morning' : 'evening';
    }

    private function determineLimitAmount($user)
    {
        $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;
        $role = $user->roles()->first();
        $roleLimitAmount = optional(RoleLimit::where('role_id', $role->id)->first())->limit ?? $defaultLimitAmount;
        return max($defaultLimitAmount, $roleLimitAmount);
    }

    private function createLotteryRecord($request, $currentSession)
    {
        return Lottery::create([
            'pay_amount' => $request->totalAmount,
            'total_amount' => $request->totalAmount,
            'user_id' => $request->user_id,
            'session' => $currentSession,
        ]);
    }
    // new logic 
    private function processBet($betDigit, $subAmount, $limitAmount, $lottery)
    {
    $twoDigit = TwoDigit::where('two_digit', sprintf('%02d', $betDigit))->first();

    if (!$twoDigit) {
        
        throw new \Exception("Invalid bet digit: {$betDigit}");
    }
    $totalBetAmount = DB::table('lottery_two_digit_copy')->where('two_digit_id', $twoDigit->id)->sum('sub_amount');

    if ($totalBetAmount + $subAmount > $limitAmount) {
        throw new \Exception('The betting limit has been reached.');
    }
    LotteryTwoDigitPivot::create([
        'lottery_id' => $lottery->id,
        'two_digit_id' => $twoDigit->id,
        'bet_digit' => $betDigit, 
        'sub_amount' => $subAmount,
        'prize_sent' => false,
    ]);
    }

}