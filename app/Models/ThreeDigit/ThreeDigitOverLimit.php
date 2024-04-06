<?php

namespace App\Models\ThreeDigit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreeDigitOverLimit extends Model
{
    use HasFactory;
    protected $table = 'lotto_three_digit_over';
    protected $fillable = ['three_digit_id', 'lotto_id', 'sub_amount', 'prize_sent'];
}