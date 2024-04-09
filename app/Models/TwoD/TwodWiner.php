<?php

namespace App\Models\TwoD;

use App\Models\User;
use App\Jobs\UpdatePrizeSent;
use App\Jobs\CheckForEveningWinners;
use App\Jobs\CheckForMorningWinners;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TwodWiner extends Model
{
    use HasFactory;
    protected $fillable = [
        'prize_no',
        'session',
    ];
     public function users()
    {
        return $this->belongsToMany(User::class);
    }
    // Inside your TwodWiner model
protected static function booted()
{
    static::created(function ($twodWiner) {
        if ($twodWiner->session == 'morning') {
            CheckForMorningWinners::dispatch($twodWiner);
            UpdatePrizeSent::dispatch($twodWiner);
        } elseif ($twodWiner->session == 'evening') {
            CheckForEveningWinners::dispatch($twodWiner);
            UpdatePrizeSent::dispatch($twodWiner);
        }
    });
}


}