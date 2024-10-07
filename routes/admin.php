<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\TransactionController;
use \App\Http\Controllers\admin\WithDrawController;
use \App\Http\Controllers\admin\BootController;
use \App\Http\Controllers\admin\SupportController;
use \App\Http\Controllers\admin\FaqController;
use \App\Http\Controllers\admin\MessageReplay;
use \App\Http\Controllers\admin\LevelController;
use \App\Http\Controllers\admin\UsersController;
use \App\Http\Controllers\admin\UserLevelController;
Route::group(['prefix' => 'admin'], function () {
    // Admin Login

    Route::controller(AdminController::class)->group(function () {
        Route::match(['post', 'get'], '/', 'login')->name('admin_login');
        Route::match(['post', 'get'], 'login', 'login')->name('admin_login');
        Route::match(['post','get'],'sign-up','signup');
        Route::match(['post','get'],'forget-password','forget_password');
    // Admin Dashboard
        Route::group(['middleware' => 'admin'], function () {
            Route::get('dashboard', 'dashboard');
    // update admin password
            Route::match(['post', 'get'], 'update_admin_password', 'update_admin_password');
    // check Admin Password
            Route::post('check_admin_password', 'check_admin_password');
    // Update Admin Details
            Route::match(['post', 'get'], 'update_admin_details', 'update_admin_details');
            Route::get('logout', 'logout')->name('logout');
        });
    });
    Route::group(['middleware' => 'admin'], function () {
        /////////// Start Transactions
        Route::controller(TransactionController::class)->group(function(){
            Route::get('transactions','index');
        });

        /////////////// Start WithDraws ///////////////
        ///
        Route::controller(WithDrawController::class)->group(function (){
            Route::get('withdraws','index');
            Route::post('withdraw/add','store');
            Route::post('withdraw/update/{id}','update');
            Route::post('withdraw/delete/{id}','delete');
        });
        ///////////////// Start BootController ////////////////
        ///
        Route::controller(BootController::class)->group(function (){
            Route::get('boots','index');
            Route::match(['post','get'],'boot/add','store');
            Route::match(['post','get'],'boot/update/{id}','update');
            Route::post('boot/delete/{id}','delete');

        });

        //////////////////// Start Message Support ////////////
        ///
        Route::controller(SupportController::class)->group(function (){
            Route::get('messages','index');
            Route::match(['post','get'],'message/add','store');
            Route::match(['post','get'],'message/update/{id}','update');
            Route::post('message/delete/{id}','delete');
        });

        //////////// Message Replay
        ///
        Route::controller(MessageReplay::class)->group(function (){
           Route::get('messages_replay/{id}','index');
           Route::match(['post','get'],'message_replay/add/{id}','store');
        });

        //////////////////// Start Faqs //////////////
        ///

        Route::controller(FaqController::class)->group(function (){
            Route::get('faqs','index');
            Route::match(['post','get'],'faq/add','store');
            Route::match(['post','get'],'faq/update/{id}','update');
            Route::post('faq/delete/{id}','delete');
        });
        ///////////////// Start Public Settings
        ///
        // Route::controller(PublicSettingController::class)->group(function () {
        //     Route::match(['post', 'get'], 'public-setting/update', 'update');
        // });

        Route::controller(LevelController::class)->group(function (){
            Route::get('levels','index');
            Route::match(['post','get'],'level/add','store');
            Route::match(['post','get'],'level/update/{id}','update');
            Route::post('level/delete/{id}','delete');
        });

        /////////////// Start Users Controller ///////////
        ///
        Route::controller(UsersController::class)->group(function (){
            Route::get('users','index');
        });

        Route::controller(UserLevelController::class)->group(function (){
            Route::get('user-levels','index');
            Route::match(['post','get'],'user-level/add','store');
            Route::match(['post','get'],'user-level/update/{id}','update');
            Route::post('user-level/delete/{id}','delete');
        });

    });
});
