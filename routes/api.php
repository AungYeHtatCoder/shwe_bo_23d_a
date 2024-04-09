<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Home\BankController;
use App\Http\Controllers\Api\V1\Home\GameController;
use App\Http\Controllers\Api\V1\Home\HomeController;
use App\Http\Controllers\Api\V1\Home\BannerController;
use App\Http\Controllers\Api\V1\Home\WalletController;
use App\Http\Controllers\Api\V1\TwoD\TwoPlayController;
use App\Http\Controllers\Api\V1\Home\PromotionController;
use App\Http\Controllers\Api\V1\Home\TwoD\TwoDController;
use App\Http\Controllers\Api\V1\ThreeD\ThreeDPlayController;
use App\Http\Controllers\Api\V1\Home\ThreeD\ThreeDController;





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    // auth
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(["middleware" => ['auth:sanctum']], function(){
        //logout
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
        
        //banner
        Route::get('/home', [HomeController::class, 'index']);
        Route::get('/banners', [BannerController::class, 'index']);
        Route::get('/banner-text', [BannerController::class, 'bannerText']);
        Route::get('/promotions', [PromotionController::class, 'index']);
        Route::get('/banks', [BankController::class, 'index']);
        Route::get('/games', [GameController::class, 'index']);

        //wallets
        Route::post('/cash-in-request', [WalletController::class, 'cashInRequest']);
        Route::post('/cash-out-request', [WalletController::class, 'cashOutRequest']);
        Route::get('/transfer-logs', [WalletController::class, 'transferLogs']);

        //2D Digits
        Route::get('/twoD-digits', [TwoDController::class, 'index']);


        //3D Digits
        Route::get('threeD-digits', [ThreeDController::class, 'index']);
        // two digit play
        Route::post('/two-d-play', [TwoPlayController::class, 'play']);
        // three digit play
        Route::post('/three-d-play', [ThreeDPlayController::class, 'play']);
    });
});