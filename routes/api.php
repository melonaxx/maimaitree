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
    Route::any('/infomation','WeixinAPIController@index');


    Route::get('/recordIndex','WeixinAPIController@recordIndex');//记工簿首页

    Route::post('/setDaySalary','WeixinAPIController@setDaySalary');//修改单日工资

    Route::get('/recordCreate','WeixinAPIController@recordCreate');//添加记工

    Route::post('/recordStore','WeixinAPIController@recordStore');//存储记工数据

    Route::get('/recordStatistics','WeixinAPIController@recordStatistics');//记工簿统计数据页

});


