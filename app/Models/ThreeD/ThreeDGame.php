<?php

namespace App\Models\ThreeD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreeDGame extends Model
{
    use HasFactory;

    protected $fillable = ['result_date', 'result_time', 'status', 'endpoint'];

    public function prizes()
    {
        return $this->hasMany(ThreeDPrize::class, 'three_d_game_id'); // Relationship with ThreeDPrizes
    }
}