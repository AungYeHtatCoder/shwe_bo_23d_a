<?php

namespace App\Models\ThreeD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultDate extends Model
{
    use HasFactory;
    protected $fillable = ['result_date', 'result_time', 'status', 'endpoint'];
}