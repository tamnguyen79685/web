<?php

use Illuminate\Support\Facades\Route;

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

//backend
Route::prefix('admin')->namespace('Admin')->group(function(){
    Route::match(['get', 'post'], '/', 'AdminController@Login');
    Route::group(['middleware'=>'admin'], function(){
        Route::get('/dashboard', 'AdminController@Index');
        Route::get('/logout', 'AdminController@Logout');
        Route::match(['get', 'post'], '/change-detail', 'AdminController@changeDetail');
        Route::match(['get', 'post'], '/change-password', 'AdminController@changePassword');
        Route::post('check-update-pwd', 'AdminController@checkUpdatePassword');
    });
});
