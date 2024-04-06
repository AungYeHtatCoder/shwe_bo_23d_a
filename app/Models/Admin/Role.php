<?php

namespace App\Models\Admin;

use App\Models\User;
use App\Models\RoleLimit;
use Illuminate\Database\Eloquent\Model;
use App\Models\ThreeDigit\ThreeRoleLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    public $table = 'roles';
    protected $date = ['created_at', 'updated_at'];

    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);

    }
    public function limits()
    {
        return $this->hasMany(RoleLimit::class, 'role_id', 'id');
    }

    public function threedrolelimits()
    {
        return $this->hasMany(ThreeRoleLimit::class, 'role_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);

    }
}