<?php

 // name = dashboard.
 Route::prefix('dashboard')
        ->name('dashboard.')
        ->middleware(['auth', 'role:super_admin|admin'])
        ->group(function () {


    // name = dashboard.index
    Route::get('/','welcomeController@index')->name('index');

    // categories route
    Route::resource('categories', 'categoriesController');

    // roles route
    Route::resource('users', 'userController');

    // roles route
    Route::resource('roles', 'roleController');

    // movies route
    Route::resource('movies', 'MovieController');

    Route::get('movies_temp/makemovierecorde', 'MovieController@makeRecorde')->name('make_recorde');

    // settings route
    Route::get('settings/social_login', 'settingsController@social_login')->name('settings.social_login');
    Route::get('settings/social_links', 'settingsController@social_links')->name('settings.social_links');
    Route::post('settings/social_login', 'settingsController@store')->name('settings.store');



});


// dd(\App\Movie::find(65)->toJSON());
//     function getActiveAttribute($value){
//
//        $array = ['0' => 'inActive', '1' => 'Active'];
//
//        $string = $array[$value];
//
//        return $string[1];
//    }
//
//echo getActiveAttribute(1);

