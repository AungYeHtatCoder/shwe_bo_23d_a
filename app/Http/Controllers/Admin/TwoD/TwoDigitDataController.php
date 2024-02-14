<?php

namespace App\Http\Controllers\Admin\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TwoDigitGetAllDataService;

class TwoDigitDataController extends Controller
{
    protected $twoDigitGetAllDataService;

    public function __construct(TwoDigitGetAllDataService $twoDigitGetAllDataService)
    {
        $this->twoDigitGetAllDataService = $twoDigitGetAllDataService;
    }

    public function morningData()
    {
        $twoDigitData = $this->twoDigitGetAllDataService->getAllTwoDigitData('morning');
        return view('admin.two_d.morning_data.morning_12_history', compact('twoDigitData'));
    }

    public function afternoonData()
    {
        $twoDigitData = $this->twoDigitGetAllDataService->getAllTwoDigitData('evening');
        return view('admin.two_d.evening_data.evening_4_history', compact('twoDigitData'));
    }
}