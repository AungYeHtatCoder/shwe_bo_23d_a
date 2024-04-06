<?php

namespace App\Http\Controllers\User\Threed;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThreeDreamBookController extends Controller
{
    public function index()
    {
        return view('three_d.threeD-dream-book');
    }
}