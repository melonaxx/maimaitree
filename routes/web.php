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

Route::get('/', function () {
    return view('/web/loading');
    // var_dump(DB::connection('mysql')->select('select * from tests limit 1'));
});
Auth::routes();

//backend
Route::get('login', '\App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::post('login', '\App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('register', '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm');
Route::post('register', '\App\Http\Controllers\Auth\RegisterController@register');