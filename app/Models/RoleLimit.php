<?php

namespace App\Models;

use App\Models\Admin\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleLimit extends Model
{
    use HasFactory;
    protected $fillable = ['role_id', 'limit'];
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}