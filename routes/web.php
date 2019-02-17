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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Auth::routes();
    Route::group([], function () {
        Route::get('home', 'HomeController@index')->name('home');
        Route::resource('artist', 'ArtistController');
        Route::resource('gallery', 'GalleryController');
        Route::resource('quiz', 'QuizController');
        Route::resource('question', 'QuestionController');
        Route::resource('prizes', 'PrizeController');
        Route::resource('movies', 'MovieController');
        Route::resource('settings', 'AppController');
        Route::resource('events','EventController');
    });
});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
    // list all lfm routes here...
});
