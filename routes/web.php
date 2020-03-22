<?php

/**
 * Global Routes
 * Routes that are used between both frontend and backend.
 */


// Switch between the included languages
Route::get('lang/{lang}', 'LanguageController@swap');

/* ----------------------------------------------------------------------- */

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */


Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
        Route::get('show', 'FrontendController@show');
        Route::get('wish/store', 'FrontendController@store')->name('storeWish');
});

Route::domain('{subdomain}.'.str_replace('https://www.','', env('APP_URL','wish-service.com')))->group( function () {
    Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
        Route::group(['middleware' => 'wl'], function () {

            includeRouteFiles(__DIR__ . '/Frontend/');
        });
    });
});
/*----------------------------------------------------------------------- */
