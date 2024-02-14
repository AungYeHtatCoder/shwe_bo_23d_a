<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ThreeD\ThreeDLimitController;
use App\Http\Controllers\Admin\TwoD\HeadDigitCloseController;
use App\Http\Controllers\Admin\TwoD\TwoDCommissionController;
use App\Http\Controllers\Admin\TwoD\TwoDigitDataController;
use App\Http\Controllers\Admin\TwoD\TwoDLimitController;
use App\Http\Controllers\Admin\TwoD\TwoDOneMonthHistoryController;
use App\Http\Controllers\Admin\TwoD\TwodRoleLimitController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\Wallet\BankController;
use App\Http\Controllers\Admin\Wallet\CashInRequestController;
use App\Http\Controllers\Admin\Wallet\CashOutRequestController;
use App\Http\Controllers\Admin\Wallet\TransferLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TwoD\TowDController;
use App\Http\Controllers\TwoD\TwoDController;
use App\Http\Controllers\TwoD\TwoDigitUserDataController;
use App\Http\Controllers\TwoD\TwoDQicklyPlayController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TwoD\TwoDLimitController;
use App\Http\Controllers\TwoD\TwoDigitUserDataController;
use App\Http\Controllers\Admin\TwoD\TwoDigitDataController;
use App\Http\Controllers\Admin\ThreeD\ThreeDLimitController;
use App\Http\Controllers\Admin\TwoD\TwoDCommissionController;
use App\Http\Controllers\Admin\TwoD\TwoDOneMonthHistoryController;

Auth::routes();

require __DIR__ . '/auth.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');
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
    // get all two digit data 
    Route::get('/two-digit-data-morning', [TwoDigitDataController::class, 'morningData'])->name('two-digit-data.morning');
    Route::get('/two-digit-data-afternoon', [TwoDigitDataController::class, 'afternoonData'])->name('two-digit-data.afternoon');

    Route::get('/two-digit-data-morning-history', [TwoDOneMonthHistoryController::class, 'morningDataHistory'])->name('two-digit-data-history.morning');
    Route::get('/two-digit-data-afternoon-history', [TwoDOneMonthHistoryController::class, 'afternoonDataHistory'])->name('two-digit-data-history.afternoon');

    // session reset
    Route::post('/two-d-session-reset', [App\Http\Controllers\Admin\TwoD\SessionResetControlller::class, 'SessionReset'])->name('SessionReset');
    // 2d open close
    Route::put('/update-open-close-two-d', [App\Http\Controllers\Admin\TwoD\CloseTwodController::class, 'update'])->name('OpenCloseTwoD');
     // three d reset
    Route::post('/three-d-reset', [App\Http\Controllers\Admin\ThreeD\ThreeDResetController::class, 'ThreeDReset'])->name('ThreeDReset');
    // 2d commission
    Route::get('/two-d-commission-index', [TwoDCommissionController::class, 'showTotalAmountByUser'])->name('two-d-commission-index');
    // show details
    Route::get('/two-d-commission-show/{id}', [TwoDCommissionController::class, 'show'])->name('two-d-commission-show');
    Route::put('/two-d-commission-update/{id}', [TwoDCommissionController::class, 'update'])->name('two-d-commission-update');
    // commission update
   Route::post('two-d-transfer-commission/{id}', [TwoDCommissionController::class, 'TwoDtransferCommission'])->name('two-d-transfer-commission');
     // Two Digit Limit
    Route::resource('/two-digit-limit', TwoDLimitController::class);
    // three Ditgit Limit
    Route::resource('/three-digit-limit', ThreeDLimitController::class);
  // head digit close 
  Route::resource('head-digit-close', HeadDigitCloseController::class);

  //wallet system
  Route::resource('banks', BankController::class);
  Route::get('/cashIn', [CashInRequestController::class, 'index'])->name('cashIn');
  Route::get('/cashIn/{id}', [CashInRequestController::class, 'show'])->name('cashIn.show');
  Route::get('/cashOut', [CashOutRequestController::class, 'index'])->name('cashOut');
  Route::get('/cashOut/{id}', [CashOutRequestController::class, 'show'])->name('cashOut.show');
  Route::post('/deposit/reject/{id}', [CashInRequestController::class, "reject"])->name('deposite-reject');
  Route::post('/deposit/accept/{id}', [CashInRequestController::class, "accept"])->name('deposite-accept');
  Route::post('/withdraw/accept/{id}', [CashOutRequestController::class, "accept"])->name('withdraw-accept');
  Route::post('/withdraw/reject/{id}', [CashOutRequestController::class, "reject"])->name('withdraw-reject');

  Route::get('/transferlogs', [TransferLogController::class, 'index'])->name('transferLog');
  //wallet system
    // head digit close 
    Route::resource('head-digit-close', HeadDigitCloseController::class);
    // get all two digit data 
    Route::get('/two-digit-data-morning', [TwoDigitDataController::class, 'morningData'])->name('two-digit-data.morning');
    Route::get('/two-digit-data-afternoon', [TwoDigitDataController::class, 'afternoonData'])->name('two-digit-data.afternoon');

    Route::get('/two-digit-data-morning-history', [TwoDOneMonthHistoryController::class, 'morningDataHistory'])->name('two-digit-data-history.morning');
    Route::get('/two-digit-data-afternoon-history', [TwoDOneMonthHistoryController::class, 'afternoonDataHistory'])->name('two-digit-data-history.afternoon');

    // session reset
    Route::post('/two-d-session-reset', [App\Http\Controllers\Admin\TwoD\SessionResetControlller::class, 'SessionReset'])->name('SessionReset');
    // 2d open close
    Route::put('/update-open-close-two-d', [App\Http\Controllers\Admin\TwoD\CloseTwodController::class, 'update'])->name('OpenCloseTwoD');
     // three d reset
    Route::post('/three-d-reset', [App\Http\Controllers\Admin\ThreeD\ThreeDResetController::class, 'ThreeDReset'])->name('ThreeDReset');
    // 2d commission
    Route::get('/two-d-commission-index', [TwoDCommissionController::class, 'showTotalAmountByUser'])->name('two-d-commission-index');
    // show details
    Route::get('/two-d-commission-show/{id}', [TwoDCommissionController::class, 'show'])->name('two-d-commission-show');
    Route::put('/two-d-commission-update/{id}', [TwoDCommissionController::class, 'update'])->name('two-d-commission-update');
    // commission update
   Route::post('two-d-transfer-commission/{id}', [TwoDCommissionController::class, 'TwoDtransferCommission'])->name('two-d-transfer-commission');
     // Two Digit Limit
    Route::resource('/two-digit-limit', TwoDLimitController::class);
    // three Ditgit Limit
    Route::resource('/three-digit-limit', ThreeDLimitController::class);
});


Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'App\Http\Controllers\User', 'middleware' => ['auth', 'checkBanned']], function () {

    //profile management
    Route::put('editProfile/{profile}', [ProfileController::class, 'update'])->name('editProfile');
    Route::post('editInfo', [ProfileController::class, 'editInfo'])->name('editInfo');
    Route::post('changePassword', [ProfileController::class, 'changePassword'])->name('changePassword');
    //profile management

  //home routes
    Route::get('/promotion', [WelcomeController::class, 'promo'])->name('promotion');
    Route::get('/promotion-detail/{id}', [WelcomeController::class, 'promotionDetail'])->name('promotionDetail');

    //wallet system
    Route::get('/wallet', [WalletController::class, 'wallet'])->name('wallet');
    Route::get('/deposit', [WalletController::class, 'deposit'])->name('deposit');
    Route::get('/deposit/{id}', [WalletController::class, 'depositBank'])->name('depositBank');
    Route::post('/deposit', [WalletController::class, 'depositStore'])->name('deposit');

    Route::get('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw');
    Route::get('/withdraw/{id}', [WalletController::class, 'withdrawBank'])->name('withdrawBank');
    Route::post('/withdraw', [WalletController::class, 'withdrawStore'])->name('withdraw');

    Route::get('/logs', [WalletController::class, 'logs'])->name('logs');
  //home routes


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
    Route::post('/two-d-play-index-4pm', [TowDController::class, 'store4pm'])->name('twod-play-index-4pm.store');
    // quick play 
    Route::get('/two-d-quick-play-index', [App\Http\Controllers\TwoD\TwoDQicklyPlayController::class, 'quick_play_index'])->name('twod-quick-play-index');
    Route::get('/two-d-play-quick-confirm', [App\Http\Controllers\TwoD\TwoDQicklyPlayController::class, 'quick_play_confirm'])->name('twod-play-confirm-quick');
    // store
    Route::post('/twod-play-quick-confirm', [App\Http\Controllers\TwoD\TwoDQicklyPlayController::class, 'store'])->name('twod-play-quickly-confirm.store');
    // 12 pm daily history
    // get all two digit data 
    Route::get('/two-digit-data-12-pm-morning', [TwoDigitUserDataController::class, 'index'])->name('two-digit-user-data.morning');
    // 4 pm daily history
    Route::get('/two-digit-data-4-30-pm-afternoon', [TwoDigitUserDataController::class, 'EveningDataHistory'])->name('two-digit-user-data.afternoon');
});

// welcome page for user route
Route::get('/promotion', [App\Http\Controllers\User\WelcomeController::class, 'promo'])->name('promotion');
Route::get('/promotion-detail/{id}', [App\Http\Controllers\User\WelcomeController::class, 'promotionDetail'])->name('promotionDetail');