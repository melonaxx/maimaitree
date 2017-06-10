<?php

Route::get('/',function(){
    return view('/BACKEND/backend');
});

Route::get('login', function(){
    return view('/BACKEND/login');
});

Route::resource('tests', 'TestController');