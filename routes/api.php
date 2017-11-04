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

    Route::any('/wxAppRecordLogin','WeixinAPIController@wxAppRecordLogin');//记工簿小程序登录


    Route::get('/recordIndex','WeixinAPIController@recordIndex');//记工簿首页

    Route::post('/setDaySalary','WeixinAPIController@setDaySalary');//修改单日工资

    Route::get('/recordCreate','WeixinAPIController@recordCreate');//添加记工

    Route::post('/recordStore','WeixinAPIController@recordStore');//存储记工数据

    Route::get('/recordStatistics','WeixinAPIController@recordStatistics');//记工簿统计数据页

    Route::get('/recordTest','WeixinAPIController@recordTest');//测试接口

    /******carpools******/
    Route::any('/carpoolLogin','CarpoolApiController@carPoolLogin');//拼车登录

    Route::post('/carpoolAdd','CarpoolApiController@carPoolAdd');//添加拼车信息

    Route::get('/carPoolList','CarpoolApiController@carPoolList');//拼车信息列表

    Route::get('/carPoolDetail','CarpoolApiController@getCarPoolDetailById');//拼车详情信息

    Route::get('/myPublishList','CarpoolApiController@myPublishList');//我发布的拼车信息列表

    Route::get('/carpoolCenter','CarpoolApiController@carpoolCenter');//我的个人中心


});

/*鄢陵人网接口*/
Route::group(['prefix' => 'yl',], function () {
    Route::any('/violation','YanLingAPIController@trafficViolation');//车辆违章查询接口

});


