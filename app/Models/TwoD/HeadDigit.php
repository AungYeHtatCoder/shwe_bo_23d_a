<?php

namespace App\Models\TwoD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadDigit extends Model
{
    use HasFactory;
    protected $fillable = ['digit_one', 'digit_two', 'digit_three'];
}