<?php

Route::get('/',function(){
    dd('backend.....');
});

Route::resource('tests', 'TestController');