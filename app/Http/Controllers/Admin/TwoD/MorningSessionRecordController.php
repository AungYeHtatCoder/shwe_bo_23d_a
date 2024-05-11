<?php

namespace App\Http\Controllers\Admin\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\EveningLotteryService;
use App\Services\MorningLotteryService;

class MorningSessionRecordController extends Controller
{
    protected $lotteryService;

    public function __construct(MorningLotteryService $lotteryService)
    {
        $this->lotteryService = $lotteryService;
    }

    public function index()
    {
        // Retrieve the open lotteries for today's morning session
        $results = $this->lotteryService->getOpenLotteriesForTodayMorning();
        $totalSubAmount = $this->lotteryService->getTotalSubAmountForTodayMorning();
        // Return the view with the results
        return view('admin.two_d.twod_results.morning_rec', [
            'results' => $results,
             'totalSubAmount' => $totalSubAmount
        ]);
    }

    
}