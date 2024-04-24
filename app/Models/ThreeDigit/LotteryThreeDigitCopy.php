<?php

namespace App\Models\ThreeDigit;

use Illuminate\Database\Eloquent\Model;
use App\Models\ThreeDigit\LotteryThreeDigitPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotteryThreeDigitCopy extends Model
{
    use HasFactory;
    protected $table = 'lotto_three_digit_copy';
    protected $fillable = ['result_date_id', 'lotto_id', 'bet_digit', 'sub_amount', 'prize_sent', 'match_status', 'res_date'];
}