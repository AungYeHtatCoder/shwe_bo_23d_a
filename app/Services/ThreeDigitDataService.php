<?php
namespace App\Services;
use Carbon\Carbon;
use App\Models\ThreeD\ThreeDigit;
use Illuminate\Support\Facades\DB;

class ThreeDigitDataService {
    

 public function getThreeDigitsData() {
    $today = Carbon::now();
    // Determine the start and end times based on the current day of the month
    $morningStart = $today->day <= 16 ? $today->copy()->startOfMonth() : $today->copy()->day(17)->startOfDay();
    $morningEnd = $today->day <= 16 ? $today->copy()->day(16)->endOfDay() : $today->copy()->addMonthNoOverflow()->day(1)->subSecond();

    $threeDigits = ThreeDigit::all();
    $data = [];
    
    foreach ($threeDigits as $digit) {
        // Data for the current period
        $periodData = DB::table('lotto_three_digit_copy')
                        ->join('lottos', 'lotto_three_digit_copy.lotto_id', '=', 'lottos.id')
                        ->where('three_digit_id', $digit->id)
                        ->whereBetween('lotto_three_digit_copy.created_at', [$morningStart, $morningEnd])
                        ->select(
                            'lotto_three_digit_copy.three_digit_id',
                            DB::raw('SUM(lotto_three_digit_copy.sub_amount) as total_sub_amount'),
                            DB::raw('GROUP_CONCAT(DISTINCT lotto_three_digit_copy.bet_digit) as bet_digits'),
                            DB::raw('COUNT(*) as total_bets'),
                            DB::raw('MAX(lotto_three_digit_copy.created_at) as latest_bet_time')
                        )
                        ->groupBy('lotto_three_digit_copy.three_digit_id')
                        ->first();

        // Store the fetched data
        $data[$digit->three_digit] = [
            'data' => $periodData,
        ];
    }

    return $data;
}

 
}