<?php

Route::get('/',function(){
    return view('/backend/backend');
});

Route::get('login', function(){
    return view('/backend/login');
});

Route::resource('tests', 'TestController');
Route::resource('recordWorks', 'RecordWorkController');
Route::resource('recordUsers', 'RecordUserController');