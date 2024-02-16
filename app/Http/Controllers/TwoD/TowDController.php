<?php

namespace App\Http\Controllers\TwoD;

use App\Models\RoleLimit;
use App\Models\TwoD\Lottery;
use Illuminate\Http\Request;
use App\Models\TwoD\TwoDigit;
use App\Models\TwoD\HeadDigit;
use App\Models\TwoD\TwoDLimit;
use App\Models\Admin\LotteryMatch;
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

    // Calculate remaining amounts for each two-digit
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

    return view('user.two_d.12_pm.index', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
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

    return view('user.two_d.12_pm.play_confirm', compact('twoDigits', 'remainingAmounts', 'lottery_matches'));
    }

//     public function store(Request $request)
// {
//     Log::info($request->all());
//     $validatedData = $request->validate([
//         'selected_digits' => 'required|string',
//         'amounts' => 'required|array',
//         'amounts.*' => 'required|integer|min:1',
//         'totalAmount' => 'required|numeric|min:1',
//         'user_id' => 'required|exists:users,id',
//     ]);

//     $currentSession = $this->determineSession();
//     $user = Auth::user();

//     // Initialize default limit
//     $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;
//     $limitAmount = $defaultLimitAmount; // Start with default limit

//     // Check user role and adjust limit accordingly
//     // $userRoles = $user->roles()->pluck('title');
//     // if ($userRoles->contains('Silver')) {
//     //     $limitAmount = 20000; // Silver limit
//     // } elseif ($userRoles->contains('Golden')) {
//     //     $limitAmount = 30000; // Golden limit
//     // } elseif ($userRoles->contains('Daimoon')) {
//     //     $limitAmount = 50000; // Daimoon limit
//     // }
//      // Dynamically adjust limit based on the user's role
//     $userRole = $user->roles()->first(); // Assuming a user has one primary role
//     if ($userRole) {
//         $roleLimit = RoleLimit::where('role_id', $userRole->id)->latest()->first();
//         if ($roleLimit) {
//             $limitAmount = $roleLimit->limit;
//         }
//     }

//     DB::beginTransaction();
//     try {
//         $user->decrement('balance', $request->totalAmount);

//         $lottery = Lottery::create([
//             'pay_amount' => $request->totalAmount,
//             'total_amount' => $request->totalAmount,
//             'user_id' => $user->id,
//             'session' => $currentSession,
//         ]);

//         foreach ($request->amounts as $two_digit_string => $sub_amount) {
//             $this->processBet($two_digit_string, $sub_amount, $limitAmount, $lottery);
//         }

//         DB::commit();
//         session()->flash('SuccessRequest', 'Successfully placed bet.');
//         return redirect()->back()->with('message', 'Bet placed successfully.');
//         //return redirect()->back()->with('message', 'Bet placed successfully.');
//     } catch (\Exception $e) {
//         DB::rollback();
//         Log::error('Error in store method: ' . $e->getMessage());
//         return redirect()->back()->with('error', $e->getMessage());
//     }
// }
    // 12 pm two d play 
    public function store(Request $request)
    {
    //Log::info($request->all());
    $validatedData = $request->validate([
        'selected_digits' => 'required|string',
        'amounts' => 'required|array',
        'amounts.*' => 'required|integer|min:1',
        'totalAmount' => 'required|numeric|min:1',
        'user_id' => 'required|exists:users,id',
    ]);

    // Fetch all head digits not allowed
    $headDigitsNotAllowed = HeadDigit::pluck('digit_one', 'digit_two', 'digit_three')->flatten()->unique()->toArray();

    // Check if any selected digit starts with the head digits not allowed
    foreach ($request->amounts as $two_digit_string => $sub_amount) {
        $headDigitOfSelected = substr($two_digit_string, 0, 1); // Extract the head digit
        if (in_array($headDigitOfSelected, $headDigitsNotAllowed)) {
            return redirect()->back()->with('error', "Bets on numbers starting with '{$headDigitOfSelected}' are not allowed.");
        }
    }

    $currentSession = $this->determineSession();
    $user = Auth::user();

    // Initialize default limit
    $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;
    
    // Adjust limit based on the user's role
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
        return redirect()->route('user.two-digit-user-data.morning')->with('success', 'Bet placed successfully.');
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
        //Log::info($request->all());
        $validatedData = $request->validate([
            'selected_digits' => 'required|string',
            'amounts' => 'required|array',
            'amounts.*' => 'required|integer|min:1',
            'totalAmount' => 'required|numeric|min:1',
            'user_id' => 'required|exists:users,id',
        ]);

        // Fetch all head digits not allowed
        $headDigitsNotAllowed = HeadDigit::pluck('digit_one', 'digit_two', 'digit_three')->flatten()->unique()->toArray();

        // Check if any selected digit starts with the head digits not allowed
        foreach ($request->amounts as $two_digit_string => $sub_amount) {
            $headDigitOfSelected = substr($two_digit_string, 0, 1); // Extract the head digit
            if (in_array($headDigitOfSelected, $headDigitsNotAllowed)) {
                return redirect()->back()->with('error', "Bets on numbers starting with '{$headDigitOfSelected}' are not allowed.");
            }
        }

        $currentSession = $this->determineSession();
        $user = Auth::user();

        // Initialize default limit
        $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;
        
        // Adjust limit based on the user's role
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
            return redirect()->route('user.two-digit-user-data.afternoon')->with('message', 'Bet placed successfully.');
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
        return ($currentTime >= '06:30' && $currentTime < '12:00') ? 'morning' : 'evening';
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

    private function processBet($two_digit_string, $sub_amount, $limitAmount, $lottery)
    {
        $two_digit_id = $two_digit_string === '00' ? 100 : intval($two_digit_string);
        $totalBetAmount = DB::table('lottery_two_digit_copy')->where('two_digit_id', $two_digit_id)->sum('sub_amount');

        if ($totalBetAmount + $sub_amount <= $limitAmount) {
            LotteryTwoDigitPivot::create([
                'lottery_id' => $lottery->id,
                'two_digit_id' => $two_digit_id,
                'sub_amount' => $sub_amount,
                'prize_sent' => false,
            ]);
        } else {
            throw new \Exception('The betting limit has been reached.');
        }
    }



// public function store(Request $request)
// {
//     Log::info($request->all());
//     $validatedData = $request->validate([
//         'selected_digits' => 'required|string',
//         'amounts' => 'required|array',
//         'amounts.*' => 'required|integer|min:1|max:900000',
//         'totalAmount' => 'required|numeric|min:1',
//         'user_id' => 'required|exists:users,id',
//     ]);

//     $currentSession = date('H') < 12 ? 'morning' : 'evening';

//     DB::beginTransaction();

//     try {
//         $user = Auth::user();
//         // Assuming roles() relationship returns all roles and we're taking the first one
//         /** @var \App\Models\User $user */
//         $role = $user->roles()->first();
//         Log::info($role);

//         $defaultLimitAmount = TwoDLimit::latest()->first()->two_d_limit;
//         $roleLimitAmount = optional(RoleLimit::where('role_id', $role->id)->first())->limit ?? $defaultLimitAmount;
//         $limitAmount = $defaultLimitAmount;
//         Log::info($roleLimitAmount);
//         $role_limit_amount =$roleLimitAmount;
//         Log::info($role_limit_amount);

//         $user->balance -= $request->totalAmount;

//         if ($user->balance < 0) {
//             throw new \Exception('Insufficient balance.');
//         }
//         $user->save();

//         foreach ($request->amounts as $two_digit_string => $sub_amount) {
//             $two_digit_id = $two_digit_string === '00' ? 100 : intval($two_digit_string);

//             $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
//                 ->where('two_digit_id', $two_digit_id)
//                 ->sum('sub_amount');

//             if ($totalBetAmountForTwoDigit + $sub_amount <= $limitAmount) {
//                 $lottery = Lottery::create([
//                 'pay_amount' => $request->totalAmount,
//                 'total_amount' => $request->totalAmount,
//                 'user_id' => $user->id,
//                 'session' => $currentSession,
//             ]);
//                 LotteryTwoDigitPivot::create([
//                     'lottery_id' => $lottery->id,
//                     'two_digit_id' => $two_digit_id,
//                     'sub_amount' => $sub_amount,
//                     'prize_sent' => false,
//                 ]);
//             } else {
//                 //throw new \Exception('ကံစမ်း၍ မရပါ');
//                 if(Auth::user()->roles()->first()->title == 'Silver' && $totalBetAmountForTwoDigit + $sub_amount <= $role_limit_amount){
//                     $lottery = Lottery::create([
//                         'pay_amount' => $request->totalAmount,
//                         'total_amount' => $request->totalAmount,
//                         'user_id' => $user->id,
//                         'session' => $currentSession,
//                     ]);
//                     LotteryTwoDigitPivot::create([
//                         'lottery_id' => $lottery->id,
//                         'two_digit_id' => $two_digit_id,
//                         'sub_amount' => $sub_amount,
//                         'prize_sent' => false,
//                     ]);
//             }elseif(Auth::user()->roles()->first()->title == 'Golden' && $totalBetAmountForTwoDigit + $sub_amount <= $role_limit_amount){
//                 $lottery = Lottery::create([
//                     'pay_amount' => $request->totalAmount,
//                     'total_amount' => $request->totalAmount,
//                     'user_id' => $user->id,
//                     'session' => $currentSession,
//                 ]);
//                 LotteryTwoDigitPivot::create([
//                     'lottery_id' => $lottery->id,
//                     'two_digit_id' => $two_digit_id,
//                     'sub_amount' => $sub_amount,
//                     'prize_sent' => false,
//                 ]);
//             }elseif(Auth::user()->roles()->first()->title == 'Daimoon' && $totalBetAmountForTwoDigit + $sub_amount <= $role_limit_amount){
//                 $lottery = Lottery::create([
//                     'pay_amount' => $request->totalAmount,
//                     'total_amount' => $request->totalAmount,
//                     'user_id' => $user->id,
//                     'session' => $currentSession,
//                 ]);
//                 LotteryTwoDigitPivot::create([
//                     'lottery_id' => $lottery->id,
//                     'two_digit_id' => $two_digit_id,
//                     'sub_amount' => $sub_amount,
//                     'prize_sent' => false,
//                 ]);
//             }else{
//                 throw new \Exception('ဂဏန်းပိတ်သွားပါပြီး');
//             }
//         }
        
//     }

//         DB::commit();
//         session()->flash('SuccessRequest', 'Successfully placed bet.');
//         return redirect()->back()->with('message', 'Bet placed successfully.');
//     } catch (\Exception $e) {
//         DB::rollback();
//         Log::error('Error in store method: ' . $e->getMessage());
//         return redirect()->back()->with('error', $e->getMessage());
//     }
// }

    //     public function store(Request $request)
// {

//     Log::info($request->all());
//     $validatedData = $request->validate([
//         'selected_digits' => 'required|string',
//         'amounts' => 'required|array',
//         'amounts.*' => 'required|integer|min:100|max:1000000',
//         //'totalAmount' => 'required|integer|min:100',
//          'totalAmount' => 'required|numeric|min:100', // Changed from integer to numeric
//         'user_id' => 'required|exists:users,id',
//     ]);

//     //$currentSession = date('H') < 12 ? 'morning' : 'evening';
//     $currentTime = date('H:i');

//     if ($currentTime >= '06:30' && $currentTime < '12:00') {
//         $currentSession = 'morning';
//     } else {
//         $currentSession = 'evening';
//     }
//    // $limitAmount = 1000000; // Define the limit amount
//     $limitAmount = TwoDLimit::latest()->first()->two_d_limit;
//     DB::beginTransaction();

//     try {
//         $user = Auth::user();
//         $user->balance -= $request->totalAmount;

//         if ($user->balance < 0) {
//             throw new \Exception('Insufficient balance.');
//         }
//         /** @var \App\Models\User $user */

//         $user->save();

//         $lottery = Lottery::create([
//             'pay_amount' => $request->totalAmount,
//             'total_amount' => $request->totalAmount,
//             'user_id' => $request->user_id,
//             'session' => $currentSession
//         ]);

//         foreach ($request->amounts as $two_digit_string => $sub_amount) {
//             $two_digit_id = $two_digit_string === '00' ? 1 : intval($two_digit_string, 10) + 1;

//             $totalBetAmountForTwoDigit = DB::table('lottery_two_digit_copy')
//                 ->where('two_digit_id', $two_digit_id)
//                 ->sum('sub_amount');

//             if ($totalBetAmountForTwoDigit + $sub_amount <= $limitAmount) {
//                 $pivot = new LotteryTwoDigitPivot([
//                     'lottery_id' => $lottery->id,
//                     'two_digit_id' => $two_digit_id,
//                     'sub_amount' => $sub_amount,
//                     'prize_sent' => false
//                 ]);
//                 $pivot->save();
//             } else {
//                 $withinLimit = $limitAmount - $totalBetAmountForTwoDigit;
//                 $overLimit = $sub_amount - $withinLimit;

//                 if ($withinLimit > 0) {
//                     $pivotWithin = new LotteryTwoDigitPivot([
//                         'lottery_id' => $lottery->id,
//                         'two_digit_id' => $two_digit_id,
//                         'sub_amount' => $withinLimit,
//                         'prize_sent' => false
//                     ]);
//                     $pivotWithin->save();
//                 }

//                 if ($overLimit > 0) {
//                     $pivotOver = new LotteryTwoDigitOverLimit([
//                         'lottery_id' => $lottery->id,
//                         'two_digit_id' => $two_digit_id,
//                         'sub_amount' => $overLimit,
//                         'prize_sent' => false
//                     ]);
//                     $pivotOver->save();
//                 }
//             }
//         }

//         DB::commit();
//         session()->flash('SuccessRequest', 'Successfully placed bet.');
//         return redirect()->back()->with('message', 'Data stored successfully!');
//     } catch (\Exception $e) {
//         DB::rollback();
//         Log::error('Error in store method: ' . $e->getMessage());
//         return redirect()->back()->with('error', $e->getMessage());
//     }
// }

}