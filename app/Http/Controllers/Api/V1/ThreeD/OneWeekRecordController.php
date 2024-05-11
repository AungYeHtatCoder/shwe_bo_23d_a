<?php

namespace App\Http\Controllers\Api\V1\ThreeD;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ThreeD\LottoThreeDigitPivot;
use App\Models\ThreeDigit\LotteryThreeDigitPivot;

class OneWeekRecordController extends Controller
{

public function oneWeekHistory(): JsonResponse
{
    $userId = Auth::id(); // Get the authenticated user's ID
    
    if (!$userId) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized',
        ], 401); // Return a 401 error if no user is authenticated
    }

    // Get the open matches for the authenticated user along with related lotto information
    $userData = LotteryThreeDigitPivot::where('match_status', 'open')
        ->join('lottos', 'lotto_three_digit_pivot.lotto_id', '=', 'lottos.id')
        ->join('users', 'lottos.user_id', '=', 'users.id')
        ->where('users.id', $userId) // Filter by the authenticated user's ID
        ->select(
            'users.name as user_name',
            'users.phone as user_phone',
            'lotto_three_digit_pivot.match_status',
            'lotto_three_digit_pivot.bet_digit',
            'lotto_three_digit_pivot.res_date as open_date',
            'lotto_three_digit_pivot.sub_amount',
            'lotto_three_digit_pivot.created_at'
        )
        ->get();

    // Calculate the total sub_amount for the authenticated user's open matches
    $totalSubAmount = LotteryThreeDigitPivot::where('match_status', 'open')
        ->join('lottos', 'lotto_three_digit_pivot.lotto_id', '=', 'lottos.id')
        ->where('lottos.user_id', $userId) // Filter by the authenticated user's ID
        ->sum('sub_amount');

    // Return the data in JSON format
    return response()->json([
        'status' => 'success',
        'total_sub_amount' => $totalSubAmount,
        'data' => $userData,
    ]);
}

}