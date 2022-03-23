<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('movie/indexBy/movie','MovieController@indexBy')->name('movie.indexBy');


Route::middleware(['auth'])->group(function(){

    Route::get('movie/{movie}', 'MovieController@show')->name('movie.show');
    Route::post('movie/{movie}/increase', 'MovieController@increaseViews')->name('movie.increaseViews');
    Route::post('movie/{movie}/addToFavorite','MovieController@addToFavorite')->name('movie.favorite');

    Route::get('profile/edit', 'UserController@profile')->name('profile.edit');
    Route::put('profile/update', 'UserController@updateProfile')->name('profile.update');

});
