<?php

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
Route::get("facebook","thirdPartyLoginController@redirectingToFacebookLogin")->name('facebook');
Route::get("landing","thirdPartyLoginController@facebooklanding")->name('landing');
Route::get('/login','authController@loginF')->name('login');
Route::get('/home/dashboard','homeController@dashboard')->name('home/dashboard');
Route::get('/{any}',function(){
    return view("routerView");
})->where('any','.*');


