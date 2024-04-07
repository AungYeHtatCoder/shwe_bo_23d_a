<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TwoD\TowDController;
use App\Http\Controllers\TwoD\TwoDController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\User\WelcomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\BannerTextController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\Wallet\BankController;
use App\Http\Controllers\ThreeD\ThreeDPlayController;
use App\Http\Controllers\TwoD\TwoDQicklyPlayController;
use App\Http\Controllers\Admin\TwoD\DataLejarController;
use App\Http\Controllers\Admin\TwoD\TwoDLagarController;
use App\Http\Controllers\Admin\TwoD\TwoDLimitController;
use App\Http\Controllers\TwoD\TwoDigitUserDataController;
use App\Http\Controllers\Admin\TwoD\TwoDigitDataController;
use App\Http\Controllers\Admin\ThreeD\ThreeDCloseController;
use App\Http\Controllers\Admin\ThreeD\ThreeDLegarController;
use App\Http\Controllers\Admin\ThreeD\ThreeDLimitController;
use App\Http\Controllers\Admin\TwoD\CloseTwoDigitController;
use App\Http\Controllers\Admin\TwoD\TwodRoleLimitController;
use App\Http\Controllers\Admin\Wallet\TransferLogController;
use App\Http\Controllers\Admin\TwoD\HeadDigitCloseController;
use App\Http\Controllers\Admin\TwoD\TwoDCommissionController;
use App\Http\Controllers\Admin\Wallet\CashInRequestController;
use App\Http\Controllers\Admin\Wallet\CashOutRequestController;
use App\Http\Controllers\TwoD\TwoDCommissionTransferController;
use App\Http\Controllers\Admin\ThreeD\ThreeDRoleLimitController;
use App\Http\Controllers\Admin\TwoD\TwoDOneMonthHistoryController;
use App\Http\Controllers\ThreeD\ThreeCommissionTransferController;


Auth::routes();

require __DIR__ . '/auth.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');
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
  Route::put('/super-admin-update-balance/{id}', [App\Http\Controllers\Admin\ProfileController::class, 'AdminUpdateBalance'])->name('admin-update-balance');
  Route::put('/change-password', [ProfileController::class, 'newPassword'])->name('changePassword');
    // PhoneAddressChange route with auth id route with put method
    Route::put('/change-phone-address', [ProfileController::class, 'PhoneAddressChange'])->name('changePhoneAddress');
    Route::put('/change-kpay-no', [ProfileController::class, 'KpayNoChange'])->name('changeKpayNo');
    Route::put('/change-join-date', [ProfileController::class, 'JoinDate'])->name('addJoinDate');
    Route::resource('banners', BannerController::class);
    Route::resource('text', BannerTextController::class);
    Route::resource('games', GameController::class);

    // head digit close 
    Route::resource('head-digit-close', HeadDigitCloseController::class);
    // two-digit-close resource route
    Route::resource('two-digit-close', CloseTwoDigitController::class);
    // morning - lajar 
    Route::get('/morning-lajar', [TwoDLagarController::class, 'showData'])->name('morning-lajar');
    // two digit data
    Route::get('/two-digit-lejar-data', [DataLejarController::class, 'showData'])->name('two-digit-lejar-data');

     Route::get('/evening-lajar', [TwoDLagarController::class, 'showDataEvening'])->name('evening-lajar');
    // two digit data
    Route::get('/evening-two-digit-lejar-data', [DataLejarController::class, 'showDataEvening'])->name('evening-two-digit-lejar-data');
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
  Route::resource('three-d-role-limits', ThreeDRoleLimitController::class);
   // three digit close
    Route::resource('three-digit-close', ThreeDCloseController::class);

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
  // two d commission route
    Route::get('/two-d-commission', [App\Http\Controllers\Admin\Commission\TwoDCommissionController::class, 'getTwoDTotalAmountPerUser'])->name('two-d-commission'); 

    // show details
    Route::get('/two-d-commission-show/{id}', [App\Http\Controllers\Admin\Commission\TwoDCommissionController::class, 'show'])->name('two-d-commission-show');
    Route::put('/two-d-commission-update/{id}', [App\Http\Controllers\Admin\Commission\TwoDCommissionController::class, 'update'])->name('two-d-commission-update');
    // commission update
   Route::post('two-d-transfer-commission/{id}', [App\Http\Controllers\Admin\Commission\TwoDCommissionController::class, 'TwoDtransferCommission'])->name('two-d-transfer-commission');
    
    // three d commission route
    Route::get('/three-d-commission', [App\Http\Controllers\Admin\Commission\ThreeDCommissionController::class, 'getThreeDTotalAmountPerUser'])->name('three-d-commission');
    // show details 
    Route::get('/three-d-commission-show/{id}', [App\Http\Controllers\Admin\Commission\ThreeDCommissionController::class, 'show'])->name('three-d-commission-show');
    // three_d_commission_update
    Route::put('/three-d-commission-update/{id}', [App\Http\Controllers\Admin\Commission\ThreeDCommissionController::class, 'update'])->name('three-d-commission-update');
    // transfer commission route
    Route::post('/three-d-transfer-commission/{id}', [App\Http\Controllers\Admin\Commission\ThreeDCommissionController::class, 'ThreeDtransferCommission'])->name('three-d-transfer-commission');
    // show transfer commission

    Route::get('/three-d-prize-number-create', [App\Http\Controllers\Admin\ThreeD\ThreeDPrizeNumberCreateController::class, 'index'])->name('three-d-prize-number-create');
    // store_permutations
    Route::post('/store-permutations', [App\Http\Controllers\Admin\ThreeD\ThreeDPrizeNumberCreateController::class, 'PermutationStore'])->name('storePermutations'); 
    //deletePermutation
    Route::delete('/delete-permutation/{id}', [App\Http\Controllers\Admin\ThreeD\ThreeDPrizeNumberCreateController::class, 'deletePermutation'])->name('deletePermutation');
    Route::post('/three-d-prize-number-create', [App\Http\Controllers\Admin\ThreeD\ThreeDPrizeNumberCreateController::class, 'store'])->name('three-d-prize-number-create.store');
    // 3d history
    Route::get('/three-d-history', [App\Http\Controllers\Admin\ThreeD\ThreeDRecordHistoryController::class, 'index'])->name('three-d-history');
    // 3d history show
    Route::get('/three-d-history-show/{id}', [App\Http\Controllers\Admin\ThreeD\ThreeDRecordHistoryController::class, 'show'])->name('three-d-history-show');
     Route::get('/three-digit-lejar', [ThreeDLegarController::class, 'showData'])->name('three-digit-lejar');
      // three digit history conclude
        Route::get('/three-digit-history-conclude', [App\Http\Controllers\Admin\ThreeD\ThreeDRecordHistoryController::class, 'OnceWeekThreedigitHistoryConclude'])->name('ThreeDigitHistoryConclude');
     // three digit one month history conclude
        Route::get('/three-digit-one-month-history-conclude', [App\Http\Controllers\Admin\ThreeD\ThreeDRecordHistoryController::class, 'OnceMonthThreedigitHistoryConclude'])->name('ThreeDigitOneMonthHistoryConclude');

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
    Route::post('/two-d-comission-transfer-to-main', [TwoDCommissionTransferController::class, 'TwodCommissiontransferToMain'])->name('twod-transfer.to.main');
    Route::post('/three-d-comission-transfer-to-main', [ThreeCommissionTransferController::class, 'ThreedCommissiontransferToMain'])->name('three-d-transfer.to.main');

    // 3d play index
    Route::get('/three-d-play-index', [App\Http\Controllers\ThreeD\ThreeDPlayController::class, 'index'])->name('three-d-play-index');
    // three-d-choice-play-index 
    Route::get('/three-d-choice-play-index', [App\Http\Controllers\ThreeD\ThreeDPlayController::class, 'choiceplay'])->name('three-d-choice-play-index');

    Route::get('/three-d-play-index', [ThreeDPlayController::class, 'index'])->name('three-d-play-index');
    // three d choice play
    Route::get('/three-d-choice-play-index', [ThreeDPlayController::class, 'choiceplay'])->name('three-d-choice-play');
    // three d choice play confirm
    Route::get('/three-d-choice-play-confirm', [ThreeDPlayController::class, 'confirm_play'])->name('three-d-choice-play-confirm');
    // three d choice play store
    Route::post('/three-d-choice-play-store', [ThreeDPlayController::class, 'store'])->name('three-d-choice-play-store');
    // display three d play
    Route::get('/three-d-display', [ThreeDPlayController::class, 'user_play'])->name('display');
    // three d dream book
    Route::get('/three-d-dream-book', [App\Http\Controllers\User\Threed\ThreeDreamBookController::class, 'index'])->name('three-d-dream-book-index');
    // three d winner history
    Route::get('/three-d-winners-history', [App\Http\Controllers\User\Threed\ThreedWinnerHistoryController::class, 'index'])->name('three-d-winners-history');


});

// welcome page for user route
Route::get('/promotion', [App\Http\Controllers\User\WelcomeController::class, 'promo'])->name('promotion');
Route::get('/promotion-detail/{id}', [App\Http\Controllers\User\WelcomeController::class, 'promotionDetail'])->name('promotionDetail');
// all ok