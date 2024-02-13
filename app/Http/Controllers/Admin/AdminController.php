<?php

namespace App\Http\Controllers\Admin;

use App\Models\ThreeD\Lotto;
use App\Models\TwoD\Lottery;
use Illuminate\Http\Request;
use App\Models\Admin\LotteryMatch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect(route('login'))->with('error', "Please Login First!");
        }

         $isAdmin = auth()->user()->hasRole('Admin');
            if ($isAdmin) {
            // Daily Total
            $dailyTotal = Lottery::whereDate('created_at', '=', now()->today())->sum('total_amount');

            // Weekly Total
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();
            $weeklyTotal = Lottery::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('total_amount');

            // Monthly Total
            $monthlyTotal = Lottery::whereMonth('created_at', '=', now()->month)
                ->whereYear('created_at', '=', now()->year)
                ->sum('total_amount');

            // Yearly Total
            $yearlyTotal = Lottery::whereYear('created_at', '=', now()->year)->sum('total_amount');

            // 3D Daily Total
            $three_d_dailyTotal = Lotto::whereDate('created_at', '=', now()->today())->sum('total_amount');

            // 3D Weekly Total
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();
            $three_d_weeklyTotal = Lotto::whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('total_amount');

            // 3D Monthly Total
            $three_d_monthlyTotal = Lotto::whereMonth('created_at', '=', now()->month)
                ->whereYear('created_at', '=', now()->year)
                ->sum('total_amount');

            // 3D Yearly Total
            $three_d_yearlyTotal = Lotto::whereYear('created_at', '=', now()->year)->sum('total_amount');
            $lottery_matches = LotteryMatch::where('id', 1)->whereNotNull('is_active')->first();
            // Return the totals, you can adjust this part as per your needs
            return view('admin.dashboard', [
                'dailyTotal'   => $dailyTotal,
                'weeklyTotal'  => $weeklyTotal,
                'monthlyTotal' => $monthlyTotal,
                'yearlyTotal'  => $yearlyTotal,
                'three_d_dailyTotal'   => $three_d_dailyTotal,
                'three_d_weeklyTotal'  => $three_d_weeklyTotal,
                'three_d_monthlyTotal' => $three_d_monthlyTotal,
                'three_d_yearlyTotal'  => $three_d_yearlyTotal,
                'lottery_matches' => $lottery_matches,
            ]);
        }else{
            return view('user.profile.user_profile');
        }
        
    }
}