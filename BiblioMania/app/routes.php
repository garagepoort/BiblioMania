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

//  BOOKS
    Route::get('getBooks', 'BookController@getBooks');
    Route::get('getFullBook', 'BookController@getFullBook');
    Route::get('getNextBooks', 'BookController@getNextBooks');
    Route::get('getBooksFromSearch', 'BookController@getBooksFromSearch');
    Route::get('createBook', 'BookController@goToCreateBook');
    Route::post('createOrEditBook', 'BookController@createOrEditBook');
    Route::get('editBook/{id}', 'BookController@goToEditBook');
    Route::get('logOut', 'LoginController@login');
    Route::get('importBooks', 'BookImportController@importBooks');

//  AUTHOR
    Route::get('getAuthor/{id}', 'AuthorController@getAuthor');
    Route::get('getAuthors', 'AuthorController@getAuthors');
    Route::get('getAuthorsList', 'AuthorController@getAuthorsList');
    Route::get('getOeuvreForAuthor/{id}', 'AuthorController@getOeuvreForAuthor');
    Route::get('getNextAuthors', 'AuthorController@getNextAuthors');
    Route::get('getAuthorsWithOeuvreJson', 'AuthorController@getAuthorsWithOeuvreJson');
    Route::post('editAuthor', 'AuthorController@editAuthor');

//  PUBLISHER
    Route::get('publisher/{id}', 'PublisherController@getPublisher');
    Route::get('getPublishersList', 'PublisherController@getPublishersList');
    Route::post('editPublisher', 'PublisherController@editPublisher');
    Route::post('deletePublisher', 'PublisherController@deletePublisher');
    Route::post('mergePublishers', 'PublisherController@mergePublishers');

//  BOOK FROM AUTHOR
    Route::post('deleteBookFromAuthor', 'AuthorController@deleteBookFromAuthor');
    Route::post('editBookFromAuthor', 'AuthorController@editBookFromAuthor');
    Route::post('updateBookFromAuthorTitle', 'AuthorController@updateBookFromAuthorTitle');

//    COUNTRY
    Route::get('getCountryList', 'CountryController@getCountryList');
    Route::post('editCountry', 'CountryController@editCountry');
    Route::post('deleteCountry', 'CountryController@deleteCountry');
    Route::post('mergeCountries', 'CountryController@mergeCountries');

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