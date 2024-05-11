<?php

namespace App\Http\Controllers\Admin\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\EveningLotteryService;

class EveningSessionRecordController extends Controller
{
    protected $lotteryService;

    public function __construct(EveningLotteryService $lotteryService)
    {
        $this->lotteryService = $lotteryService;
    }

    public function index()
    {
        // Retrieve the open lotteries for today's morning session
        $results = $this->lotteryService->getOpenLotteriesForTodayEvening();
        $totalSubAmount = $this->lotteryService->getTotalSubAmountForTodayEvening();
        // Return the view with the results
        return view('admin.two_d.twod_results.evening_rec', [
            'results' => $results,
             'totalSubAmount' => $totalSubAmount
        ]);
    }
}