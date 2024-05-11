<?php

namespace App\Models\TwoD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryTwoDigitCopy extends Model
{
    use HasFactory;
    protected $table = 'lottery_two_digit_copy';
    protected $fillable = ['lottery_id', 'twod_game_result_id', 'bet_digit', 'sub_amount', 'prize_sent', 'match_status', 'res_date', 'res_time', 'session'];
}