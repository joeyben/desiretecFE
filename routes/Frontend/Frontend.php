<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */



//Route::group(['domain' => 'localhost'], function () {
    Route::get('/', 'FrontendController@index')->name('index');
    Route::get('/getTTRegions', 'RegionsController@getTTRegions');
    Route::get('/get-all-destinations', 'FrontendController@getAllDestinations');
    Route::get('/get-all-airports', 'FrontendController@getAllAirports');
    Route::get('/get-tt-airports', 'RegionsController@getTTAirports');
    Route::get('macros', 'FrontendController@macros')->name('macros');
//Route::post('/get/states', 'FrontendController@getStates')->name('get.states');
//Route::post('/get/cities', 'FrontendController@getCities')->name('get.cities');


Route::get('show', 'FrontendController@show');

Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {
    Route::post('api/login', 'AuthController@login')->name('api.login');
    Route::get('api/logout', 'AuthController@logout')->name('api.logout');
    Route::post('api/link', 'AuthController@link')->name('api.link');
    Route::get('api/token/{token}', 'AuthController@token')->name('api.token');
});

Route::group(['namespace' => 'Wishes', 'as' => 'wishes.'], function () {
    Route::get('wishlist', 'WishesController@wishList')->name('list');

    Route::get('wishes', 'WishesController@index')->name('index');
    Route::get('wish/new', 'WishesController@newWish');
    Route::get('wish/newuser', 'WishesController@newUserWish');
    Route::get('wish/offertextlink', 'WishesController@offerLink');
    Route::get('wish/offerviatext', 'WishesController@offerText');
    Route::get('wish/attach', 'WishesController@attach');
    Route::get('wish/{wish}', 'WishesController@show')->name('wish');

    Route::post('wishes/get', 'WishesTableController')->name('get');
    Route::get('wishes/getlist', 'WishesController@getList')->name('getlist');
    Route::post('wishes/changeWishStatus', 'WishesController@changeWishStatus')->name('changeWishStatus');
    Route::post('wishes/updateNote', 'WishesController@updateNote')->name('updateNote');

    Route::get('wishes/create', 'WishesController@create')->name('create');

    Route::get('wish/{wish}/{token}', 'WishesController@validateTokenWish')->name('details');
    Route::get('wish/{wish}', 'WishesController@show')->name('show');
    Route::get('getwish/{wish}', 'WishesController@getWish')->name('getWish');
    Route::post('wish/store', 'WishesController@store')->name('store');
    Route::get('wish/edit/{wish}', 'WishesController@edit')->name('edit');
    Route::get('wish/destroy', 'WishesController@destroy')->name('destroy');
    Route::patch('wish/update/{wish}', 'WishesController@update')->name('update');

});


Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
    /*
     * User Dashboard Specific
     */
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    /*
     * User Account Specific
     */
    Route::get('account', 'AccountController@index')->name('account');

    /*
     * User Profile Specific
     */
    Route::post('profile/update', 'ProfileController@update')->name('profile.update');

    /*
     * User Profile Picture
     */
    Route::patch('profile-picture/update', 'ProfileController@updateProfilePicture')->name('profile-picture.update');
});


    /*
     * These frontend controllers require the user to be logged in
     * All route names are prefixed with 'frontend.'
     */
    Route::group(['middleware' => 'auth'], function () {
        // Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        //     /*
        //      * User Dashboard Specific
        //      */
        //     Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        //     /*
        //      * User Account Specific
        //      */
        //     Route::get('account', 'AccountController@index')->name('account');

        //     /*
        //      * User Profile Specific
        //      */
        //     Route::post('profile/update', 'ProfileController@update')->name('profile.update');

        //     /*
        //      * User Profile Picture
        //      */
        //     Route::patch('profile-picture/update', 'ProfileController@updateProfilePicture')->name('profile-picture.update');
        // });

        Route::group(['namespace' => 'Offers', 'as' => 'offers.'], function () {
            Route::get('offers', 'OffersController@index')->name('index');
            Route::post('offers/get', 'OffersTableController')->name('get');
            Route::get('offers/create/{id}', 'OffersController@create')->name('create');
            Route::post('offers/store', 'OffersController@store')->name('store');
            Route::post('offers/edit', 'OffersController@edit')->name('edit');
            Route::post('offers/destroy', 'OffersController@destroy')->name('destroy');

            Route::get('wish/offers/{wish}', 'OffersController@getWishOffers')->name('showoffers');

            Route::post('wish/getoffers', 'OffersTableController@showOffersForWish')->name('wishoffers');

        });

        Route::group(['namespace' => 'Comments', 'as' => 'comments.'], function () {

            Route::get('comments', 'CommentsController@index')->name('index');
            Route::post('comment/store', 'CommentsController@store')->name('store');

        });

        Route::group(['namespace' => 'Contact', 'as' => 'contact.'], function () {

            Route::post('contact/store', 'ContactController@store')->name('store');
            Route::post('callback/store', 'ContactController@storeCallback')->name('storecallback');

        });

        Route::group(['namespace' => 'Messages', 'as' => 'messages.'], function () {
            Route::post('messages', 'MessagesController@sendMessage');
            Route::get('messages/{wish}/{group}', 'MessagesController@getMessages');
            Route::get('message/delete/{message}', 'MessagesController@deleteMessage');
            Route::post('message/edit', 'MessagesController@editMessage');

        });

        Route::group(['namespace' => 'Agents', 'as' => 'agents.'], function () {
            Route::get('agents', 'AgentsController@index')->name('index');
            Route::get('agent/profile', 'AgentsController@profile')->name('profile');
            Route::get('agents/create', 'AgentsController@create')->name('create');
            Route::post('agents/store', 'AgentsController@store')->name('store');
            Route::get('agents/edit/{id}', 'AgentsController@edit')->name('edit');
            Route::post('agents/update/{id}', 'AgentsController@update')->name('update');
            Route::get('agents/delete/{id}', 'AgentsController@delete')->name('delete');
        });

    });

    /*
    * Show pages
    */
    Route::get('pages/{slug}', 'FrontendController@showPage')->name('pages.show');


    Route::get('/tnb', 'FrontendController@showTnb')->name('tnb');

//});
