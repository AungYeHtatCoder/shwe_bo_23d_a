<?php

namespace App\Http\Controllers\Admin\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TwoDigitGetAllDataService;

class TwoDOneMonthHistoryController extends Controller
{
    protected $twoDigitGetAllDataService;

    public function __construct(TwoDigitGetAllDataService $twoDigitGetAllDataService)
    {
        $this->twoDigitGetAllDataService = $twoDigitGetAllDataService;
    }

    public function morningDataHistory()
    {
        $twoDigitData = $this->twoDigitGetAllDataService->getAllTwoDigitData('morning');
        return view('admin.two_d.history.morning_12_history', compact('twoDigitData'));
    }

    public function afternoonDataHistory()
    {
        $twoDigitData = $this->twoDigitGetAllDataService->getAllTwoDigitData('evening');
        return view('admin.two_d.history.evening_4_history', compact('twoDigitData'));
    }
}