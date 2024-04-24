<?php

namespace App\Models\ThreeD;

use App\Models\ThreeD\PrizeNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThreeDPrize extends Model
{
    use HasFactory;
    protected $fillable = ['three_d_game_id', 'name', 'reward', 'amount']; // Ensure 'three_d_game_id' is in fillable

    public function prizeNumbers()
    {
        return $this->hasMany(PrizeNumber::class, 'three_d_prize_id'); // Relationship with PrizeNumbers
    }

    public function game()
    {
        return $this->belongsTo(ThreeDGame::class, 'three_d_game_id'); // Relationship with ThreeDGame
    }
}