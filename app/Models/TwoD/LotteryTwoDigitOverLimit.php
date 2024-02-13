<?php

namespace App\Models\TwoD;

use Illuminate\Database\Eloquent\Model;
use App\Models\TwoD\LotteryOverLimitCopy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotteryTwoDigitOverLimit extends Model
{
    use HasFactory;
    protected $table = 'lottery_over_limit';
    protected $fillable = ['lottery_id', 'two_digit_id', 'sub_amount', 'prize_sent'];
    protected static function booted()
    {
        static::created(function ($pivot) {
            LotteryOverLimitCopy::create($pivot->toArray());
        });
    }
}