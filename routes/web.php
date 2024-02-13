<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TwoD\TowDController;
use App\Http\Controllers\TwoD\TwoDController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\User\WelcomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\TwoD\TwodRoleLimitController;
use App\Http\Controllers\Admin\TwoD\HeadDigitCloseController;



Auth::routes();

require __DIR__ . '/auth.php';

Route::get('/home', [AdminController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::get('/', [App\Http\Controllers\User\WelcomeController::class, 'index'])->name('welcome');



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'checkBanned']], function () {
  // Permissions
  Route::delete('permissions/destroy', [PermissionController::class, 'massDestroy'])->name('permissions.massDestroy');
  Route::resource('permissions', PermissionController::class);
  // Roles
  Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
  Route::resource('roles', RolesController::class);
  // Users
  Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
  Route::resource('users', UsersController::class);
  Route::put('users/{id}/ban', [UsersController::class, 'banUser'])->name('users.ban');
  Route::resource('role-limits', TwodRoleLimitController::class);
  // admin profile
  Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
  Route::resource('profiles', ProfileController::class);
  Route::put('/change-password', [ProfileController::class, 'newPassword'])->name('changePassword');
    // PhoneAddressChange route with auth id route with put method
    Route::put('/change-phone-address', [ProfileController::class, 'PhoneAddressChange'])->name('changePhoneAddress');
    Route::put('/change-kpay-no', [ProfileController::class, 'KpayNoChange'])->name('changeKpayNo');
    Route::put('/change-join-date', [ProfileController::class, 'JoinDate'])->name('addJoinDate');
  // head digit close 
  Route::resource('head-digit-close', HeadDigitCloseController::class);
});


Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'App\Http\Controllers\User', 'middleware' => ['auth', 'checkBanned']], function () {

    //profile management
    Route::put('editProfile/{profile}', [ProfileController::class, 'update'])->name('editProfile');
    Route::post('editInfo', [ProfileController::class, 'editInfo'])->name('editInfo');
    Route::post('changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');
    //profile management
    Route::get('/dashboard', [App\Http\Controllers\User\WelcomeController::class, 'dashboard'])->name('dashboard');
    // 12 pm two d play index
    Route::get('/two-d-play-index', [TowDController::class, 'index'])->name('twod-play-index');
    Route::get('/two-d-play-index-12pm', [TowDController::class, 'twelvepm'])->name('twod-play-index-12pm');
    // 12:00 pm confirm page
    Route::get('/two-d-play-12-1-morning-confirm', [TowDController::class, 'play_confirm'])->name('twod-play-confirm-12pm');
    // store
    Route::post('/two-d-play-index-12pm', [TowDController::class, 'store'])->name('twod-play-index-12pm.store');

    // 4:00 pm index
    Route::get('/two-d-play-index-4pm', [TowDController::class, 'fourpm'])->name('twod-play-index-4pm');
    // 2:00 pm confirm page
    Route::get('/two-d-play-4-30-evening-confirm', [TowDController::class, 'play_confirm4pm'])->name('twod-play-confirm-4pm');
    // store
    Route::post('/two-d-play-index-4pm', [TowDController::class, 'store'])->name('twod-play-index-4pm.store');
    // quick play 
    Route::get('/two-d-quick-play-index', [App\Http\Controllers\TwoD\TwoDQicklyPlayController::class, 'quick_play_index'])->name('twod-quick-play-index');
    Route::get('/two-d-play-quick-confirm', [App\Http\Controllers\TwoD\TwoDQicklyPlayController::class, 'quick_play_confirm'])->name('twod-play-confirm-quick');
    // store
    Route::post('/twod-play-quick-confirm', [App\Http\Controllers\TwoD\TwoDQicklyPlayController::class, 'store'])->name('twod-play-quickly-confirm.store');
});

// welcome page for user route
Route::get('/promotion', [App\Http\Controllers\User\WelcomeController::class, 'promo'])->name('promotion');
Route::get('/promotion-detail/{id}', [App\Http\Controllers\User\WelcomeController::class, 'promotionDetail'])->name('promotionDetail');