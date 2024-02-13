<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferLog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'amount', 'type', 'status', 'created_by'];

    public function user(){
        return $this->belongsTo(User::class); // 1 user has many transfer logs
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
