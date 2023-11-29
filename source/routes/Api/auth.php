<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    //Route::post('login', 'LoginController@login');

    Route::post('register', 'RegisterController@register');

    /* ------------------------------------------------------------------- */
    // development/testing endpoint

    Route::post('create-testing-token', 'LoginController@createTestingToken')->middleware('route-dev');


});
