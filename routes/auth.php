<?php 
use App\Http\Controllers\Authentication\AuthController;
use Illuminate\Support\Facades\Route;



//auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
//auth routes