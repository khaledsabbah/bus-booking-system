<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'bus' , 'namespace' => 'Bus'], function () {
    Route::get('list','BuController@listAll')->name('api.bus.list');
    Route::apiResource('','BuController')->parameters(['' => 'id']);
});
