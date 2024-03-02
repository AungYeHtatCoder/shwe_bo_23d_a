<?php

namespace App\Http\Controllers\Admin\TwoD;

use Illuminate\Http\Request;
use App\Models\TwoD\TwoDigit;
use App\Http\Controllers\Controller;
use App\Services\TwoDigitDataService;

class DataLejarController extends Controller
{
    protected $lotteryService;

    public function __construct(TwoDigitDataService $lotteryService)
    {
        $this->lotteryService = $lotteryService;
    }

    public function showData()
{
    $sessionsData = $this->lotteryService->getTwoDigitsData();
    
    return view('admin.two_d.lajar.morning_lejar', [
        'data' => $sessionsData, 
        
    ]);
}

}