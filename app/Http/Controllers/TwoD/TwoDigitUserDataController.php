<?php

namespace App\Http\Controllers\TwoD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TwoDigitUserGetAllDataService;

class TwoDigitUserDataController extends Controller
{
    protected $twoDigitGetAllDataService;

    public function __construct(TwoDigitUserGetAllDataService $twoDigitGetAllDataService)
    {
        $this->twoDigitGetAllDataService = $twoDigitGetAllDataService;
    }

    public function index()
    {
        $morningData = $this->twoDigitGetAllDataService->getUserTwoDigitData('morning');
        // $userEveningTwoDigitData = $this->twoDigitGetAllDataService->getUserTwoDigitData('evening');

        // Assuming 'user.two_digit_data.index' is the path to your blade file
        // return view('user.two_d.history.morning_history', compact('userMorningTwoDigitData'));
        return view('user.two_d.history.morning_history', [
            'morningData' => $morningData['data'], // Access the data part
        'totalMorningSubAmount' => $morningData['totalSubAmount'],
        ]);
    }

    public function EveningDataHistory()
    {
        $userEveningTwoDigitData = $this->twoDigitGetAllDataService->getUserTwoDigitData('evening');

        // Assuming 'user.two_digit_data.index' is the path to your blade file
        return view('user.two_d.history.evening_history', compact('userEveningTwoDigitData'));
    
    }
}