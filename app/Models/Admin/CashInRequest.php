<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashInRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_method', 
        'amount', 
        'currency',
        'phone', 
        'user_id', 
        'last_6_num', 
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
