<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashOutRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_method', 
        'amount', 
        'currency',
        'phone', 
        'user_id',  
        'status',
        'name'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
