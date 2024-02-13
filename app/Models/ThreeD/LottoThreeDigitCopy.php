<?php

namespace App\Models\ThreeD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LottoThreeDigitCopy extends Model
{
    use HasFactory;
    protected $table = 'lotto_three_digit_copy';
    protected $fillable = ['three_digit_id', 'lotto_id', 'sub_amount', 'prize_sent'];
}