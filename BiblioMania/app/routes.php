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

//USER
Route::group(array('before' => 'auth'), function() {
    Route::get('getBooks/{id?}', 'BookController@getBooks');
    Route::get('getBooksFromSearch', 'BookController@getBooksFromSearch');
    Route::get('createBook', 'BookController@goToCreateBook');
    Route::post('createBook', 'BookController@createBook');
    Route::get('logOut', 'LoginController@login');
    Route::get('importBooks', 'BookImportController@importBooks');
    Route::get('getAuthor/{id}', 'AuthorController@getAuthor');
    Route::get('getAuthors', 'AuthorController@getAuthors');
    Route::get('scaleImages', 'ImageController@scaleImages');
});


//ALL
Route::get('login', 'LoginController@goToLogin');
Route::post('login', 'LoginController@login');
Route::get('changeLanguage/{lang}', 'LanguageController@changeLanguage');

Route::post('createUser', 'UserController@createUser');
Route::get('createUser', 'UserController@goToCreateUser');

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