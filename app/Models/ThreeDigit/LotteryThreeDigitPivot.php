<?php

namespace App\Models\ThreeDigit;

use Illuminate\Database\Eloquent\Model;
use App\Models\ThreeDigit\LotteryThreeDigitCopy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotteryThreeDigitPivot extends Model
{
    use HasFactory;
    protected $table = 'lotto_three_digit_pivot';
    protected $fillable = ['result_date_id', 'lotto_id', 'bet_digit', 'sub_amount', 'prize_sent', 'match_status', 'res_date'];

    // This will automatically boot with the model's events
    protected static function booted()
    {
        static::created(function ($pivot) {
            LotteryThreeDigitCopy::create($pivot->toArray());
        });
    }
}