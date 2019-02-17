<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
Route::get('artistList', 'ArtistController@getAllArtist');
Route::get('quizList', 'QuizController@getAllQuiz');
Route::get('questionList', 'QuestionController@getAllQuestions');
Route::get('prizesList', 'PrizeController@getAllPrizes');
Route::get('movieList', 'MovieController@getAllMovies');
Route::get('eventList','EventController@list');


Route::get('profile','API\UserController@profile');
Route::patch('profile','API\UserController@updateProfile');
Route::get('settings','AppController@getSettings');

Route::group(['prefix'=>'quiz'],function(){
    Route::get('main','API\QuizController@getAllMainQuiz');
    Route::get('quizList','API\QuizController@list');
    Route::get('{mainId}/child','API\QuizController@getChildQuiz');
    Route::get('{quizId}/prizes','API\QuizController@getPrizes');
    Route::get('{quizId}/questions','API\QuizController@getQuestions');
});

Route::group(['prefix'=>'movies'],function(){
    Route::get('/','API\MovieController@index');
    Route::get('/released','API\MovieController@released');
});

Route::group(['prefix' => 'events'], function () {
    Route::get('/', 'API\EventController@index');
    Route::get('{id}', 'API\EventController@show');
});
