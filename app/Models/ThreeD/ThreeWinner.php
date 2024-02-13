<?php

namespace App\Models\ThreeD;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThreeWinner extends Model
{
    use HasFactory;
    protected $table = 'three_winners';
    protected $fillable = ['prize_no'];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}