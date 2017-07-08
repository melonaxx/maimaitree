<?php

Route::get('/',function(){
    return view('/Backend/backend');
});

Route::get('login', function(){
    return view('/Backend/login');
});

Route::resource('tests', 'TestController');
Route::resource('recordWorks', 'RecordWorkController');