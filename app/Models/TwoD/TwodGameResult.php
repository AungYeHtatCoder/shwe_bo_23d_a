<?php

namespace App\Models\TwoD;

use App\Jobs\UpdatePrizeSent;
use App\Jobs\CheckForEveningWinners;
use App\Jobs\CheckForMorningWinners;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TwodGameResult extends Model
{
    use HasFactory;
    protected $fillable = ['result_date', 'result_time', 'result_number', 'session', 'status'];


    protected static function booted()
    {
        static::updated(function ($twodWiner) {
            if ($twodWiner->session === 'morning') {
                CheckForMorningWinners::dispatch($twodWiner);
                //UpdatePrizeSent::dispatch($twodWiner);
            } elseif ($twodWiner->session === 'evening') {
                CheckForEveningWinners::dispatch($twodWiner);
                //UpdatePrizeSent::dispatch($twodWiner);
            }
        });
    }

}