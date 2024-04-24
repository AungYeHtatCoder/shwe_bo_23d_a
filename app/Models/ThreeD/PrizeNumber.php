<?php

namespace App\Models\ThreeD;

use App\Models\ThreeD\ThreeDPrize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrizeNumber extends Model
{
    use HasFactory;
     protected $fillable = ['three_d_prize_id', 'number']; // Ensure 'three_d_prize_id' is in fillable

    public function prize()
    {
        return $this->belongsTo(ThreeDPrize::class, 'three_d_prize_id'); // Relationship with ThreeDPrize
    }
}