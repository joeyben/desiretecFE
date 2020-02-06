<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

use App\Services\Api\ApiService;
use Illuminate\Support\Facades\URL;

Route::domain('{subdomain}.wish-service.com')->group(function () {
    $subdomain_str = str_replace('.wish-service.com','', URL::current());
    $subdomain_str = str_replace('https://','', $subdomain_str);
    $cachedWhitelabel = Cache::get( 'whitelabel' );
    if(!$cachedWhitelabel || strtolower($cachedWhitelabel->name) !=  $subdomain_str){
        $api = resolve(ApiService::class);
        $whitelabel = $api->getWlInfo($subdomain_str);
        Cache::forever( 'whitelabel', $whitelabel);
    }


    Route::get('/', 'FrontendController@index')->name('index');
    Route::get('show', 'FrontendController@show');
    Route::get('/getTTRegions', 'RegionsController@getTTRegions');
    Route::get('/get-all-destinations', 'FrontendController@getAllDestinations');
    Route::get('/get-all-airports', 'FrontendController@getAllAirports');
    Route::get('/get-tt-airports', 'RegionsController@getTTAirports');
    Route::get('macros', 'FrontendController@macros')->name('macros');
    Route::get('pages/{slug}', 'FrontendController@showPage')->name('pages.show');
    Route::get('/tnb', 'FrontendController@showTnb')->name('tnb');


    Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function ($subdomain) {
        Route::post('api/login', 'AuthController@login')->name('api.login');
        Route::get('api/logout', 'AuthController@logout')->name('api.logout');
        Route::post('api/link', 'AuthController@link')->name('api.link');
        Route::get('api/token/{token}', 'AuthController@token')->name('api.token');
    });


    /*
    * These frontend controllers require the user to be logged in
    * All route names are prefixed with 'frontend.'
    */
    Route::group(['middleware' => 'auth'], function ($subdomain) {

        Route::group(['namespace' => 'Users', 'as' => 'user.'], function ($subdomain) {
            Route::get('account', 'AccountController@index')->name('account');
            Route::put('account/update/{id}', 'AccountController@update')->name('update');
            Route::patch('account/profilepic/update', 'AccountController@updateProfilePicture')->name('profile-picture');
        });

        Route::group(['namespace' => 'Comments', 'as' => 'comments.'], function ($subdomain) {
            Route::get('comments', 'CommentsController@index')->name('index');
            Route::post('comment/store', 'CommentsController@store')->name('store');
        });

        Route::group(['namespace' => 'Contact', 'as' => 'contact.'], function ($subdomain) {
            Route::post('contact/store', 'ContactController@store')->name('store');
            Route::post('callback/store', 'ContactController@storeCallback')->name('storecallback');
        });

        Route::group(['namespace' => 'Messages', 'as' => 'messages.'], function ($subdomain) {
            Route::get('messages/{wish}/{group}', 'MessagesController@list')->name('list');
            Route::post('messages', 'MessagesController@create')->name('create');
            Route::post('messages/{id}', 'MessagesController@update')->name('update');
            Route::get('messages/{id}', 'MessagesController@delete')->name('delete');
        });

        Route::group(['namespace' => 'Offers', 'as' => 'offers.'], function ($subdomain) {
            Route::get('offers', 'OffersController@index')->name('index');
            Route::post('offers/get', 'OffersTableController')->name('get');
            Route::get('offers/create/{id}', 'OffersController@create')->name('create');
            Route::post('offers/store', 'OffersController@store')->name('store');
            Route::post('offers/edit', 'OffersController@edit')->name('edit');
            Route::post('offers/destroy', 'OffersController@destroy')->name('destroy');

            Route::get('wish/offers/{wish}', 'OffersController@getWishOffers')->name('showoffers');

            Route::post('wish/getoffers', 'OffersTableController@showOffersForWish')->name('wishoffers');
        });

        Route::group(['namespace' => 'Agents', 'as' => 'agents.'], function ($subdomain) {
            Route::get('agents', 'AgentsController@index')->name('index');
            Route::get('agent/profile', 'AgentsController@profile')->name('profile');
            Route::get('agents/create', 'AgentsController@create')->name('create');
            Route::post('agents/store', 'AgentsController@store')->name('store');
            Route::get('agents/edit/{id}', 'AgentsController@edit')->name('edit');
            Route::post('agents/update/{id}', 'AgentsController@update')->name('update');
            Route::get('agents/delete/{id}', 'AgentsController@delete')->name('delete');
        });

        Route::group(['namespace' => 'Wishes', 'as' => 'wishes.'], function ($subdomain) {
            Route::get('wishlist', 'WishesController@wishList')->name('list');
            Route::get('wishes/getlist', 'WishesController@getList')->name('getlist');

            Route::get('wishes/{id}', 'WishesController@show')->name('wish');
            Route::post('wishes/note/update', 'WishesController@updateNote')->name('updateNote');
        });
    });
});
