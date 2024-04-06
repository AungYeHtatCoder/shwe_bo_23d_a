<?php

namespace App\Models\ThreeDigit;

use App\Models\Admin\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThreeRoleLimit extends Model
{
    use HasFactory;
    protected $fillable = ['role_id', 'limit'];
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}