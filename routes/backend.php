<?php

Route::get('/',function(){
    return view('/backend/backend');
});

Route::get('login', function(){
    return view('/backend/login');
});

Route::resource('tests', 'TestController');//测试

Route::resource('recordWorks', 'RecordWorkController');//记工簿记录

Route::resource('recordUsers', 'RecordUserController');//记工簿用户

Route::resource('users', 'UsersController');//拼车用户

Route::resource('carpools', 'CarpoolsController');//拼车信息

Route::resource('someups', 'SomeupsController');//拼车信息