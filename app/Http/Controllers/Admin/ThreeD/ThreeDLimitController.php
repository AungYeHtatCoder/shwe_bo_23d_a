<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Carbon\Carbon;
use App\Models\ThreeD\Lotto;
use Illuminate\Http\Request;
use App\Models\ThreeD\ThreeDLimit;
use App\Models\ThreeD\ThreeWinner;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ThreeDLimitController extends Controller
{
    public function index()
    {
       $limits = ThreeDLimit::all();
        return view('admin.three_d.three_limit.index', compact('limits'));
    }
    public function store(Request $request)
    {
       //dd($request->all());
        $validator = Validator::make($request->all(), [
        'three_d_limit' => 'required',

        //'body' => 'required|min:3'
    ]);

    if ($validator->fails()) {
        return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
    }

        // store
        ThreeDLimit::create([
            'three_d_limit' => $request->three_d_limit
        ]);
        // redirect
        return redirect()->route('admin.three-digit-limit.index')->with('toast_success', 'three d limit created successfully.');
    }

    public function destroy($id)
    {
        $limit = ThreeDLimit::findOrFail($id);
        $limit->delete();
        return redirect()->route('admin.three-digit-limit.index')->with('toast_success', 'Limit deleted successfully.');
    }

    // three d over limit list
    public function overLimit()
    {
        $today = Carbon::now();
        if ($today->day <= 1) {
            $targetDay = 1;
        } else {
            $targetDay = 16;
            // If today is after the 16th, then target the 1st of next month
            if ($today->day > 16) {
                $today->addMonthNoOverflow();
                $today->day = 1;
            }
        }
        $matchTime = DB::table('threed_match_times')
            ->whereMonth('match_time', '=', $today->month)
            ->whereYear('match_time', '=', $today->year)
            ->whereDay('match_time', '=', $targetDay)
            ->first();
        $lotteries = Lotto::with(['DisplayThreeDigitsOver', 'lotteryMatch.threedMatchTime'])->orderBy('id', 'desc')->get();
        $prize_no = ThreeWinner::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
    
        return view('admin.three_d.three_d_over_limit_list_index', compact('lotteries', 'prize_no', 'matchTime'));
    }
   

public function SameThreeDigitIDoverLimit()
{
    $today = Carbon::now();
    $targetDay = $today->day <= 1 ? 1 : 16;
    if ($today->day > 16) {
        $today = $today->startOfMonth()->addMonth();
    }

    $matchTime = DB::table('threed_match_times')
        ->whereMonth('match_time', '=', $today->month)
        ->whereYear('match_time', '=', $today->year)
        ->whereDay('match_time', '=', $targetDay)
        ->first();

    // Retrieve the Lotto records along with related over limit three digits
    $lotteries = Lotto::with(['DisplayThreeDigitsOver', 'lotteryMatch.threedMatchTime'])
                    ->orderBy('id', 'desc')
                    ->get();

    // Aggregate sub_amounts for each three_digit_id
    // $aggregatedData = DB::table('lotto_three_digit_over')
    //                     ->selectRaw('three_digit_id, SUM(sub_amount) as total_sub_amount')
    //                     ->groupBy('three_digit_id')
    //                     ->pluck('total_sub_amount', 'three_digit_id');
    // $aggregatedData = DB::table('lotto_three_digit_over')
    //                     ->join('three_digits', 'lotto_three_digit_over.three_digit_id', '=', 'three_digits.id')
    //                     ->selectRaw('three_digits.three_digit, SUM(lotto_three_digit_over.sub_amount) as total_sub_amount')
    //                     ->groupBy('three_digits.three_digit')
    //                     ->pluck('total_sub_amount', 'three_digits.three_digit');

    $aggregatedData = DB::table('lotto_three_digit_over')
                        ->join('three_digits', 'lotto_three_digit_over.three_digit_id', '=', 'three_digits.id')
                        ->selectRaw('lotto_three_digit_over.three_digit_id, three_digits.three_digit, SUM(lotto_three_digit_over.sub_amount) as total_sub_amount')
                        ->groupBy('lotto_three_digit_over.three_digit_id', 'three_digits.three_digit')
                        ->get();
    $prize_no = ThreeWinner::whereDate('created_at', Carbon::today())
                           ->orderBy('id', 'desc')
                           ->first();

    return view('admin.three_d.same_id_over_limit_list_index', compact('lotteries', 'prize_no', 'matchTime', 'aggregatedData'));
}

   

//     public function SameThreeDigitIDoverLimit()
//     {
//     $today = Carbon::now();
//     $targetDay = $today->day <= 1 ? 1 : 16;
//     // If today is after the 16th, then target the 1st of next month
//     if ($today->day > 16) {
//         $today = $today->startOfMonth()->addMonth();
//     }

//     $matchTime = DB::table('threed_match_times')
//         ->whereMonth('match_time', '=', $today->month)
//         ->whereYear('match_time', '=', $today->year)
//         ->whereDay('match_time', '=', $targetDay)
//         ->first();

//     // Retrieve the Lotto records along with related over limit three digits
//     $lotteries = Lotto::with(['DisplayThreeDigitsOver' => function ($query) {
//                         $query->groupBy('three_digit_id')
//                               ->havingRaw('COUNT(*) > 1');
//                     }, 'lotteryMatch.threedMatchTime'])
//                     ->orderBy('id', 'desc')
//                     ->get();

//     $prize_no = ThreeWinner::whereDate('created_at', Carbon::today())
//                            ->orderBy('id', 'desc')
//                            ->first();

//     return view('admin.three_d.same_id_over_limit_list_index', compact('lotteries', 'prize_no', 'matchTime'));
// }



}