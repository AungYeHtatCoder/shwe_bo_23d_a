<?php

namespace App\Models\TwoD;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteryOverLimitCopy extends Model
{
    use HasFactory;
    protected $table = 'lottery_over_limit_copy';
    protected $fillable = ['lottery_id', 'two_digit_id', 'sub_amount', 'prize_sent'];
     
}