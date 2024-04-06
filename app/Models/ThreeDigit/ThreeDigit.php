<?php

namespace App\Models\ThreeDigit;

use App\Models\ThreeDigit\Lotto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThreeDigit extends Model
{
    use HasFactory;

    protected $fillable = ['three_digit'];
     public function lottos() {
        return $this->belongsToMany(Lotto::class, 'lotto_three_digit_pivot')->withPivot('sub_amount');
    }
}