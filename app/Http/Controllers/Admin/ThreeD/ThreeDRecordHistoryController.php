<?php

namespace App\Http\Controllers\Admin\ThreeD;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ThreeDigit\Lotto;
use App\Models\Admin\ThreeDDLimit;
use App\Models\ThreeD\ThreeDLimit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ThreeDigit\ThreeWinner;

class ThreeDRecordHistoryController extends Controller
{
   public function index()
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
        $lotteries = Lotto::with(['threedDigits', 'lotteryMatch.threedMatchTime'])->orderBy('id', 'desc')->get();
        $prize_no = ThreeWinner::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
    
        return view('admin.three_d.three_d_history', compact('lotteries', 'prize_no', 'matchTime'));
    }
    
    public function show(string $id)
    {
        $lottery = Lotto::with('threedDigits')->findOrFail($id);
        $prize_no = ThreeWinner::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->first();
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
        return view('admin.three_d.three_d_history_show', compact('lottery', 'prize_no', 'matchTime'));
    }

     public function OnceWeekThreedigitHistoryConclude()
    {
        $userId = auth()->id(); // Get logged in user's ID
        $displayJackpotDigit = User::getAdminthreeDigitsHistory();
        $three_limits = ThreeDLimit::orderBy('id', 'desc')->first();
        return view('admin.three_d.one_week_conclude', [
            'displayThreeDigits' => $displayJackpotDigit,
            'three_limits' => $three_limits,
        ]);
    }

    public function OnceMonthThreedigitHistoryConclude()
    {
        $userId = auth()->id(); // Get logged in user's ID
        $displayJackpotDigit = User::getAdminthreeDigitsOneMonthHistory();
        $three_limits = ThreeDLimit::orderBy('id', 'desc')->first();
        return view('admin.three_d.one_month_conclude', [
            'displayThreeDigits' => $displayJackpotDigit,
            'three_limits' => $three_limits,
        ]);
    }

}