<?php

namespace App\Http\Controllers\Api\V1\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\EveningLotteryService;
use App\Services\ApiMorningLotteryService;

class OnedayMorningHistoryController extends Controller
{
    protected $lotteryService;

    public function __construct(ApiMorningLotteryService $lotteryService)
    {
        $this->lotteryService = $lotteryService;
    }

    public function index()
    {
        // Retrieve the open lotteries for today's morning session
        $results = $this->lotteryService->getAuthUserTodayMorning();
        $totalSubAmount = $this->lotteryService->getTotalSubAmountForTodayMorning();
        
        return response()->json([
        'status' => 'success',
        'total_sub_amount' => $totalSubAmount,
        'data' => $results,
    ]);
    }

    public function eveningRecord()
    {
        // Retrieve the open lotteries for today's morning session
        $results = $this->lotteryService->getTotalSubAmountForTodayMorning();
        $totalSubAmount = $this->lotteryService->getTotalSubAmountForTodayMorning();
        // Return the view with the results
        // return view('admin.two_d.twod_results.evening_rec', [
        //     'results' => $results,
        //      'totalSubAmount' => $totalSubAmount
        // ]);
        return response()->json([
        'status' => 'success',
        'total_sub_amount' => $totalSubAmount,
        'data' => $results,
    ]);
    }
}