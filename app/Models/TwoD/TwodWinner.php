<?php

namespace App\Models\TwoD;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TwodWinner extends Model
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
}