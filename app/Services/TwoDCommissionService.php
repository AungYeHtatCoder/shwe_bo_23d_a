<?php 
namespace App\Services;
use App\Models\TwoD\Lottery;
use Illuminate\Support\Facades\DB;

class TwoDCommissionService
{
    public function getTotalAmountByUser()
    {
        // Aggregate total_amount by user_id
        // $totals = Lottery::select('user_id', DB::raw('SUM(total_amount) as total_amount'))
        //                  ->groupBy('user_id')
        //                  ->get();

        // If you want to include user details, assuming there's a 'user' relationship defined in Lottery model:
        // $totalsWithUser = Lottery::with('user')
        //                  ->select('user_id', DB::raw('SUM(total_amount) as total_amount'))
        //                  ->groupBy('user_id')
        //                  ->get();

        // return $totalsWithUser;
        // return Lottery::with('user')
        //               ->select('user_id', DB::raw('SUM(total_amount) as total_amount'))
        //               ->groupBy('user_id')
        //               ->get();
        return Lottery::with('user')
                  ->select('user_id', DB::raw('SUM(total_amount) as total_amount'), DB::raw('MAX(id) as latest_lottery_id'))
                  ->groupBy('user_id')
                  ->get();
    }
}