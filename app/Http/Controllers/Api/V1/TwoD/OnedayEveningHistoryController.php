<?php

namespace App\Http\Controllers\Api\V1\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiEveningLotteryService;

class OnedayEveningHistoryController extends Controller
{
    protected $lotteryService;

    public function __construct(ApiEveningLotteryService $lotteryService)
    {
        $this->lotteryService = $lotteryService;
    }

    public function index()
    {
        // Retrieve the open lotteries for today's morning session
        $results = $this->lotteryService->getAuthUserTodayEvening();
        $totalSubAmount = $this->lotteryService->TotalSubAmountForTodayEvening();
        
        return response()->json([
        'status' => 'success',
        'total_sub_amount' => $totalSubAmount,
        'data' => $results,
    ]);
    }
}