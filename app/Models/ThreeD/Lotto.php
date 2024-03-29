<?php

namespace App\Models\ThreeD;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ThreeD\ThreeDigit;
use App\Models\Admin\LotteryMatch;
use App\Models\Admin\ThreedMatchTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lotto extends Model
{
    use HasFactory;
     protected $fillable = [
        'total_amount',
        'user_id',
        //'session',
        'lottery_match_id',
        'comission',
        'commission_amount',
        'status',
    ];
    protected $dates = ['created_at', 'updated_at'];

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lotteryMatch()
    {
        return $this->belongsTo(LotteryMatch::class, 'lottery_match_id');
    }
    public function threedMatchTime()
    {
        // Assuming you have a model called ThreedMatchTime and there is a 'lottery_match_id' foreign key in it.
        return $this->hasOne(ThreedMatchTime::class, 'id', 'lottery_match_id');
    }

     public function threedDigits() {
        return $this->belongsToMany(ThreeDigit::class, 'lotto_three_digit_copy')->withPivot('sub_amount', 'prize_sent')->withTimestamps();
    }

   
}