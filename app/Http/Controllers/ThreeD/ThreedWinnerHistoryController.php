<?php

namespace App\Http\Controllers\User\Threed;

use Illuminate\Http\Request;
use App\Models\ThreeDigit\Lotto;
use App\Http\Controllers\Controller;

class ThreedWinnerHistoryController extends Controller
{
    public function index()
    {
        $winners = Lotto::whereHas('threedDigits', function ($query) {
            $query->where('prize_sent', 1);
        })->with(['threedDigits' => function ($query) {
            $query->where('prize_sent', 1);
        }])->get();
        return view('three_d.threed-winner-history', compact('winners'));
        //return response()->json($winners);
    }
}