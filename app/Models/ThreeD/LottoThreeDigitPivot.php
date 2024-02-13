<?php

namespace App\Models\ThreeD;

use Illuminate\Database\Eloquent\Model;
use App\Models\ThreeD\LottoThreeDigitCopy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LottoThreeDigitPivot extends Model
{
    use HasFactory;
    protected $table = 'lotto_three_digit_pivot';
    protected $fillable = ['three_digit_id', 'lotto_id', 'sub_amount', 'prize_sent'];

    // This will automatically boot with the model's events
    protected static function booted()
    {
        static::created(function ($pivot) {
            LottoThreeDigitCopy::create($pivot->toArray());
        });
    }
}