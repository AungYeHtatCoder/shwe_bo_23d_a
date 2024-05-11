<?php

namespace App\Models\TwoD;

use Illuminate\Database\Eloquent\Model;
use App\Models\TwoD\LotteryTwoDigitCopy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotteryTwoDigitPivot extends Model
{
    use HasFactory;
    protected $table = 'lottery_two_digit_pivot';
    protected $fillable = ['lottery_id', 'twod_game_result_id', 'bet_digit', 'sub_amount', 'prize_sent', 'match_status', 'res_date', 'res_time', 'session'];
    // This will automatically boot with the model's events
    protected static function booted()
    {
        static::created(function ($pivot) {
            LotteryTwoDigitCopy::create($pivot->toArray());
        });
    }
}