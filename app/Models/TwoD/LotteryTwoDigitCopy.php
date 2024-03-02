<?php

namespace App\Models\TwoD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryTwoDigitCopy extends Model
{
    use HasFactory;
    protected $table = 'lottery_two_digit_copy';
    protected $fillable = ['lottery_id', 'two_digit_id', 'bet_digit', 'sub_amount', 'prize_sent'];
}