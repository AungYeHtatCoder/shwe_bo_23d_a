<?php

namespace App\Models\TwoD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoDLimit extends Model
{
    use HasFactory;
    protected $fillable = [
        'two_d_limit',
    ];
}