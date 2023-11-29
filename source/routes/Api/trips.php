<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'trips' , 'namespace' => 'Trips'], function () {
    Route::get('list','TripController@listAll')->name('api.trips.list');
    Route::apiResource('','TripController')->parameters(['' => 'id']);
});
