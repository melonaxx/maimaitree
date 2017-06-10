<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/',function(){
    dd('api.....');
});

/*小程序*/
Route::group(['prefix' => 'miniapp',], function () {

    //消息推送服务器配置接口
    Route::any('/checkSignature','WeixinAPIController@index');

});


