<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//ALL
Route::get('login', 'LoginController@goToLogin');
Route::post('login', 'LoginController@login');
Route::get('changeLanguage/{lang}', 'LanguageController@changeLanguage');

Route::get('/', function()
{
    if(Auth::check()){
        return Redirect::to('getBooks');
    }else{
        return Redirect::to('login')
            ->with('login_errors', true);
    }
});

App::missing(function($exception)
{
    return Redirect::to('getBooks');
});