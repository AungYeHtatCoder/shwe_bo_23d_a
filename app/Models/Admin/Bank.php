<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $fillable = ['bank', 'phone', 'name', 'image', 'currency'];
    protected $appends = ['img_url'];
    public function getImgUrlAttribute()
    {
        return asset('assets/img/banks/' . $this->image);
    }
}