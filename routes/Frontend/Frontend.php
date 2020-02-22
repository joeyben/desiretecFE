<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

use App\Services\Api\ApiService;
use Illuminate\Support\Facades\URL;




Route::get('/', 'FrontendController@index')->name('index');

Route::get('show', 'FrontendController@show');
Route::get('wish/store', 'FrontendController@store')->name('storeWish');

Route::get('/destinations', 'FrontendController@getAllDestinations');
Route::get('/airports', 'FrontendController@getAllAirports');
Route::get('/get-tt-airports', 'RegionsController@getTTAirports');
Route::get('/getTTRegions', 'RegionsController@getTTRegions');
Route::get('macros', 'FrontendController@macros')->name('macros');
Route::get('pages/{slug}', 'FrontendController@showPage')->name('pages.show');
Route::get('/tnb', 'FrontendController@showTnb')->name('tnb');


Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function ($subdomain) {
    Route::post('api/login', 'AuthController@login')->name('api.login');
    Route::get('api/logout', 'AuthController@logout')->name('api.logout');
    Route::post('api/link', 'AuthController@link')->name('api.link');
    Route::get('api/token', 'AuthController@token')->name('api.token');
});

Route::group(['namespace' => 'Admin'], function ($subdomain) {
    Route::get('cache/clear', 'CacheController@clear')->name('cache.clear');
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

    Route::group(['namespace' => 'Comments', 'as' => 'comments.'], function () {
        Route::get('comments', 'CommentsController@index')->name('index');
        Route::post('comment/store', 'CommentsController@store')->name('store');
    });

    Route::group(['namespace' => 'Contact', 'as' => 'contact.'], function () {
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
        Route::get('agent/switch/{id}', 'AgentsController@switch')->name('switch');
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
        Route::post('wishes/changeWishStatus', 'WishesController@changeWishStatus')->name('changeWishStatus');
        Route::post('wishes/note/update', 'WishesController@updateNote')->name('updateNote');
    });

    Route::group(['namespace' => 'Autooffers', 'as' => 'autooffer.'], function ($subdomain) {
        Route::get('offer/list/{wishId}', 'AutooffersController@list')->name('list');
        Route::get('offer/ttlist/{wishId}', 'AutooffersController@listTt')->name('listTt');
    });
});
