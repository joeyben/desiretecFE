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
Route::domain('{subdomain}.wish-service.com')->group( function () {
    Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
        Route::group(['middleware' => 'wl'], function () {

            includeRouteFiles(__DIR__ . '/Frontend/');
        });
    });
});
/*----------------------------------------------------------------------- */
