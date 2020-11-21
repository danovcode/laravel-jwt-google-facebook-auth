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

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/google', 'App\Http\Controllers\GoogleLoginController@redirectToGoogle');
Route::get('auth/google/callback', 'App\Http\Controllers\GoogleLoginController@handleGoogleCallback');

Route::get('auth/facebook', 'App\Http\Controllers\FbLoginController@redirectToFacebook')->name('auth.facebook');;
Route::get('auth/facebook/callback', 'App\Http\Controllers\FbLoginController@handleFacebookCallback')->name('auth.facebook.callback');
