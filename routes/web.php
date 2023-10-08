<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/gettime', function() {
    $time = date('Y-m-d H:i:s');
    return response()->json(['time' => $time]);
});

Route::POST('checkRefral', [App\Http\Controllers\User\UserController::class, 'checkRefral']);
Route::get('/', function () {
    return view('LandingPage.Home.main_index');
});

// frontPages Routes
Route::get('/Home/index',function(){
return view('LandingPage.Home.main_index');
});

Route::get('/Home/index',function(){
    return view('LandingPage.Home.main_index');
    });
    
//  Login signup routes



//Admin pannel after Login Start

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {
        return view('index');
    });


Route::get('/deposit_now',function(){
    return view('modules.Cash_Deposit.index');
});


//// Spatie
Route::get('logout', [App\Http\Controllers\User\UserController::class, 'logout']);
Route::get('createrole', [App\Http\Controllers\User\UserRoleController::class, 'createRole']);
Route::get('createpermission', [App\Http\Controllers\User\UserRoleController::class, 'createPermission']);
Route::get('assignpermission', [App\Http\Controllers\User\UserRoleController::class, 'assignPermission']);
Route::POST('manage-permission', [App\Http\Controllers\User\UserRoleController::class, 'changePermission']);
Route::get('assignrole', [App\Http\Controllers\User\UserRoleController::class, 'assignRole']);


Route::get('/my-password', function () {
    return view('modules.Users.myPassword');
    });
Route::POST('user-password', [App\Http\Controllers\User\UserController::class,'userPassword']);
Route::POST('user-edit', [App\Http\Controllers\User\UserController::class,'editUser']);
Route::POST('update-user', [App\Http\Controllers\User\UserController::class,'updateUser']);
Route::POST('update-password', [App\Http\Controllers\User\UserController::class,'updatePassword']);
Route::POST('update-my-password', [App\Http\Controllers\User\UserController::class,'myPassword']);



/// RP Conversion
Route::resource('/Convert-to-rp',App\Http\Controllers\User\RpConversionHistoryController::class);


///All users 
Route::get('/users', [App\Http\Controllers\User\UserController::class, 'allUsers']);

Route::POST('/getUserDetail', [App\Http\Controllers\User\UserController::class, 'getUserDetail']);
Route::POST('/deactivate_user', [App\Http\Controllers\User\UserController::class, 'deactivateUser']);
Route::POST('/activate_user', [App\Http\Controllers\User\UserController::class, 'activateUser']);
Route::POST('/delete_user', [App\Http\Controllers\User\UserController::class, 'deleteUser']);
// ....stats...

Route::get('/stats', [App\Http\Controllers\User\StatsController::class, 'index']);

// important links
Route::get('/important_links',function(){
    return view('modules.Important_Links.index');
});

// Bv Log

Route::resource('/bv_log',App\Http\Controllers\User\BvLogController ::class); 
Route::get('/bv_log_history',[App\Http\Controllers\User\BvLogController ::class,'bvLogs']); 
Route::get('/cbv_log',[App\Http\Controllers\User\BvLogController ::class,'cbvLogs']); 
//Referrals

Route::get('/referrals', [App\Http\Controllers\User\UserController::class, 'myReferrals']);
Route::POST('/referral_tree', [App\Http\Controllers\User\UserController::class, 'myReferral_tree']);
//Network SUmmary
Route::get('/network', [App\Http\Controllers\User\UserController::class, 'networkSummary']);
Route::POST('/networkSummaryRefrals', [App\Http\Controllers\User\UserController::class, 'networkSummaryRefrals']);
//Balance Transfer
Route::get('/transfer', [App\Http\Controllers\Admin\TransferPointController::class, 'BalanceTransfer']);
Route::get('/balance-sent', [App\Http\Controllers\Admin\TransferPointController::class, 'BalanceSent']);
Route::get('/balance-recieved', [App\Http\Controllers\Admin\TransferPointController::class, 'BalanceRecieved']);
Route::resource('transfer-points',App\Http\Controllers\Admin\TransferPointController::class);

Route::get('/transfer-c_wallet', [App\Http\Controllers\Admin\CwalletController::class, 'BalanceTransferCwallet']);
Route::resource('c-wallet',App\Http\Controllers\Admin\CwalletController::class);






//Withdraw

// Route::get('/withdraw_now',function(){
//     return view('modules.withdraw.index');
// });

Route::resource('/withdraw',App\Http\Controllers\Admin\WithdrawTransactionsController ::class); 
Route::GET('/withdraw-transactions', [App\Http\Controllers\Admin\WithdrawTransactionsController::class , 'Transactions']);

Route::POST('/approve_withdraw', [ App\Http\Controllers\Admin\WithdrawTransactionsController::class,'approve_transaction']);
Route::POST('/cancell_withdraw', [ App\Http\Controllers\Admin\WithdrawTransactionsController::class,'cancell_transaction']);

//complaint
Route::resource('/complaint', App\Http\Controllers\Admin\ComplaintsController::class);
Route::POST('delete_complaint', [App\Http\Controllers\Admin\ComplaintsController::class, 'deleteComplaint']);
Route::POST('/approve_complaint', [ App\Http\Controllers\Admin\ComplaintsController::class,'approveComplaint']);
Route::POST('/cancell_complaint', [ App\Http\Controllers\Admin\ComplaintsController::class,'cancellComplaint']);
Route::get('create_complaint', [App\Http\Controllers\Admin\ComplaintsController::class, 'create']);


//Ticket support

ROute::get('/ticket',function(){
    return view('modules.Ticket_Support.index');
});

//User Profile

//Trasaction
Route::resource('/transactions', App\Http\Controllers\User\TransactionsController::class);
Route::POST('/approve_deposit', [ App\Http\Controllers\User\TransactionsController::class,'approve_transaction']);
Route::POST('/cancell_deposit', [ App\Http\Controllers\User\TransactionsController::class,'cancell_transaction']);
Route::resource('/User', App\Http\Controllers\User\UserController::class);
Route::GET('/user-profile', [App\Http\Controllers\User\UserController::class , 'UserProfile']);
Route::POST('/user-show', [App\Http\Controllers\User\UserController::class , 'UserShow']);
Route::POST('/drawTree', [App\Http\Controllers\User\UserController::class , 'drawTree']);





//login history

Route::get('/login-history',[App\Http\Controllers\Admin\LoginHistoryController::class, 'LoginHistory']);
Route::POST('/DeleteLoginHistory', [App\Http\Controllers\Admin\LoginHistoryController::class, 'DeleteLoginHistory']);


//Transactions History
Route::get('/transactions_history',[App\Http\Controllers\User\TransactionsController::class, 'TransactionHistory']);
Route::POST('/DeleteTransactionHistory', [App\Http\Controllers\User\TransactionsController::class, 'DeleteTransactionHistory']);


//Withdraw History


//First Commission
Route::get('/first_Commission',function(){
    return view('modules.Reports.First_Commission');
});

//Withdraw Transaction History

Route::get('/withdraw-history',[App\Http\Controllers\Admin\WithdrawTransactionsController::class, 'WithdrawHistory']);
Route::POST('/DeleteWithdrawTransactionHistory', [App\Http\Controllers\Admin\WithdrawTransactionsController::class, 'DeleteWithdrawTransactionHistory']);
//Buy History
Route::get('/convert-bv', [App\Http\Controllers\Admin\DashboardController::class, 'convertBv']);
Route::get('/Buy_History',function(){
    return view('modules.Reports.Buy_History');
});

//Bonus2 Commission

Route::get('/Bonus2_Commission',function(){
    return view('modules.Reports.Bonus2_Commission');
});

/// Account Details 
Route::get('/deposit_accounts',function(){
    return view('modules.AccountDetails.show');
});
Route::resource('/account-details', App\Http\Controllers\Admin\AdminAccountDetailsController::class);
// Account Details

//kyc

Route::get('/KYC', [App\Http\Controllers\User\UserKycController::class, 'myKyc']);
Route::POST('/show-kyc', [App\Http\Controllers\User\UserKycController::class, 'showKyc']);
Route::POST('/approve-kyc', [App\Http\Controllers\User\UserKycController::class, 'approveKyc']);
Route::POST('/cancell-kyc', [App\Http\Controllers\User\UserKycController::class, 'cancellKyc']);
Route::POST('/pending-kyc', [App\Http\Controllers\User\UserKycController::class, 'pendingKyc']);
Route::resource('/user_kyc', App\Http\Controllers\User\UserKycController::class);

});


Route::resource('/packages', App\Http\Controllers\User\PackagesController::class);
Route::resource('/purchased-plans', App\Http\Controllers\User\PurchasedPlanController::class);
Route::get('/users_packages', [App\Http\Controllers\User\PurchasedPlanController::class, 'allPackages']);

///packages
