<?php

Route::post('/authuser', 'AuthController@login');
Route::post('/registeruser', 'RegisterController@store');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/infouser', 'UserController@show');
    Route::put('/updateinfouser', 'UserController@edit');
});
