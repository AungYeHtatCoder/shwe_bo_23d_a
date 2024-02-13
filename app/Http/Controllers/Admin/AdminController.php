<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect(route('login'))->with('error', "Please Login First!");
        }
        return view('admin.dashboard');
    }
}
