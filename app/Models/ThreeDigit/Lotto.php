<?php

namespace App\Models\ThreeDigit;

use Carbon\Carbon;
// use App\Models\Admin\ThreedDigit;
use App\Models\User;
use App\Models\Admin\LotteryMatch;
use App\Models\Admin\ThreedMatchTime;
use App\Models\ThreeDigit\ThreeDigit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lotto extends Model
{
    use HasFactory;
     protected $fillable = [
        'total_amount',
        'user_id',
        //'session',
        'lottery_match_id',
        'comission',
        'commission_amount',
        'status',
    ];
    protected $dates = ['created_at', 'updated_at'];

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lotteryMatch()
    {
        return $this->belongsTo(LotteryMatch::class, 'lottery_match_id');
    }
    public function threedMatchTime()
    {
        return $this->hasOne(ThreedMatchTime::class, 'id', 'lottery_match_id');
    }

    //  public function threedDigits() {
    //     return $this->belongsToMany(ThreeDigit::class, 'lotto_three_digit_pivot')->withPivot('sub_amount', 'prize_sent')->withTimestamps();
    // }
    
    public function threedDigits() {
        return $this->belongsToMany(ThreeDigit::class, 'lotto_three_digit_pivot')
                     ->withPivot('sub_amount', 'prize_sent')
                     ->withTimestamps('pivot_created_at', 'pivot_updated_at');
    }
    

    public function DisplayThreeDigits()
    { 
        return $this->belongsToMany(ThreeDigit::class, 'lotto_three_digit_copy', 'lotto_id', 'three_digit_id')->withPivot('sub_amount', 'prize_sent', 'created_at');
    }  

//     public function displayThreeDigitsOneWeekHistory()
// {
//     $digitIds = $this->pluck('id');
//     $startDateFirstRange = Carbon::now()->startOfMonth();
//     $endDateFirstRange = $startDateFirstRange->copy()->addDays(16);
//     $startDateSecondRange = $endDateFirstRange->copy()->addDay();
//     $endDateSecondRange = Carbon::now()->endOfMonth();

//     return $this->belongsToMany(ThreeDigit::class, 'lotto_three_digit_pivot', 'lotto_id', 'three_digit_id')
//         ->select(['three_digits.*', 'lotto_three_digit_pivot.*'])
//         ->where(function ($query) use ($startDateFirstRange, $endDateFirstRange, $startDateSecondRange, $endDateSecondRange) {
//             $query->whereBetween('lotto_three_digit_pivot.created_at', [$startDateFirstRange, $endDateFirstRange])
//                   ->orWhereBetween('lotto_three_digit_pivot.created_at', [$startDateSecondRange, $endDateSecondRange]);
//         })
//         ->whereIn('lotto_three_digit_pivot.lotto_id', $digitIds)
//         ->orderBy('lotto_three_digit_pivot.created_at', 'desc');
// }


//     public function displayThreeDigitsOneWeekHistory($jackpotIds = [])
// {
//     // If no specific jackpot IDs are provided, fetch all jackpot IDs
//     if (empty($digitIds)) {
//         $digitIds = Lotto::pluck('id');
//     }
//     // Define your date ranges using Carbon
//     $startDateFirstRange = Carbon::now()->startOfMonth();
//     $endDateFirstRange = Carbon::now()->startOfMonth()->addDays(16);
//     $startDateSecondRange = Carbon::now()->startOfMonth()->addDays(17);
//     $endDateSecondRange = Carbon::now()->endOfMonth();

//     return $this->belongsToMany(ThreeDigit::class, 'lotto_three_digit_pivot', 'lotto_id', 'three_digit_id')
//         ->select([
//             'three_digits.*', 
//             'lotto_three_digit_pivot.lotto_id AS pivot_lotto_id', 
//             'lotto_three_digit_pivot.three_digit_id AS pivot_three_digit_id', 
//             'lotto_three_digit_pivot.sub_amount AS pivot_sub_amount', 
//             'lotto_three_digit_pivot.prize_sent AS pivot_prize_sent', 
//             'lotto_three_digit_pivot.created_at AS pivot_created_at', 
//             'lotto_three_digit_pivot.updated_at AS pivot_updated_at'
//         ])
//         ->where(function ($query) use ($startDateFirstRange, $endDateFirstRange, $startDateSecondRange, $endDateSecondRange) {
//             $query->whereBetween('lotto_three_digit_pivot.created_at', [$startDateFirstRange, $endDateFirstRange])
//                   ->orWhereBetween('lotto_three_digit_pivot.created_at', [$startDateSecondRange, $endDateSecondRange]);
//         })
//         ->whereIn('lotto_three_digit_pivot.lotto_id', $digitIds)
//         ->orderBy('lotto_three_digit_pivot.created_at', 'desc');

// }
    
    
    public function displayThreeDigitsOneWeekHistory($jackpotIds = [])
    {
    // If no specific jackpot IDs are provided, fetch all jackpot IDs
    if (empty($jackpotIds)) {
        $jackpotIds = Lotto::pluck('id');
    }

    // Define your date ranges using Carbon
    if (Carbon::now()->day <= 16) {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->startOfMonth()->addDays(16);
    } else {
        $startDate = Carbon::now()->startOfMonth()->addDays(16);
        $endDate = Carbon::now()->addMonthNoOverflow()->startOfMonth();
    }

    return $this->belongsToMany(ThreeDigit::class, 'lotto_three_digit_pivot', 'lotto_id', 'three_digit_id')
        ->select([
            'three_digits.*', 
            'lotto_three_digit_pivot.lotto_id AS pivot_lotto_id', 
            'lotto_three_digit_pivot.three_digit_id AS pivot_three_digit_id', 
            'lotto_three_digit_pivot.sub_amount AS pivot_sub_amount', 
            'lotto_three_digit_pivot.prize_sent AS pivot_prize_sent', 
            'lotto_three_digit_pivot.created_at AS pivot_created_at', 
            'lotto_three_digit_pivot.updated_at AS pivot_updated_at'
        ])
        ->whereBetween('lotto_three_digit_pivot.created_at', [$startDate, $endDate])
        ->whereIn('lotto_three_digit_pivot.lotto_id', $jackpotIds)
        ->orderBy('lotto_three_digit_pivot.created_at', 'desc');
}

    public function displayThreeDigitsOneMonthHistory($jackpotIds = [])
{
    // If no specific jackpot IDs are provided, fetch all jackpot IDs
    if (empty($jackpotIds)) {
        $jackpotIds = Lotto::pluck('id');
    }
    // Define your date ranges using Carbon
    $startDate = Carbon::now()->startOfMonth();
    $endDate = Carbon::now()->addMonthNoOverflow()->startOfMonth()->addDay(); // This will give you the second day of the next month

    return $this->belongsToMany(ThreeDigit::class, 'lotto_three_digit_pivot', 'lotto_id', 'three_digit_id')
        ->select([
            'three_digits.*', 
            'lotto_three_digit_pivot.lotto_id AS pivot_lotto_id', 
            'lotto_three_digit_pivot.three_digit_id AS pivot_three_digit_id', 
            'lotto_three_digit_pivot.sub_amount AS pivot_sub_amount', 
            'lotto_three_digit_pivot.prize_sent AS pivot_prize_sent', 
            'lotto_three_digit_pivot.created_at AS pivot_created_at', 
            'lotto_three_digit_pivot.updated_at AS pivot_updated_at'
        ])
        ->whereBetween('lotto_three_digit_pivot.created_at', [$startDate, $endDate])
        ->whereIn('lotto_three_digit_pivot.lotto_id', $jackpotIds)
        ->orderBy('lotto_three_digit_pivot.created_at', 'desc');
}
}