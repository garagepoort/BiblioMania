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
    Route::get('getBooks', 'BookController@getBooks');
    Route::get('getNextBooks', 'BookController@getNextBooks');
    Route::get('getBooksFromSearch', 'BookController@getBooksFromSearch');
    Route::get('createBook', 'BookController@goToCreateBook');
    Route::post('createOrEditBook', 'BookController@createOrEditBook');
    Route::get('editBook/{id}', 'BookController@goToEditBook');
    Route::get('logOut', 'LoginController@login');
    Route::get('importBooks', 'BookImportController@importBooks');

    Route::get('getAuthor/{id}', 'AuthorController@getAuthor');
    Route::get('getAuthors', 'AuthorController@getAuthors');
    Route::get('getAuthorsList', 'AuthorController@getAuthorsList');
    Route::get('getOeuvreForAuthor/{id}', 'AuthorController@getOeuvreForAuthor');
    Route::get('getNextAuthors', 'AuthorController@getNextAuthors');
    Route::get('getAuthorsWithOeuvreJson', 'AuthorController@getAuthorsWithOeuvreJson');
    Route::post('editAuthor', 'AuthorController@editAuthor');

    Route::get('publisher/{id}', 'PublisherController@getPublisher');
    Route::get('getPublishersList', 'PublisherController@getPublishersList');
    Route::post('editPublisher', 'PublisherController@editPublisher');
    Route::post('deletePublisher', 'PublisherController@deletePublisher');
    Route::post('mergePublishers', 'PublisherController@mergePublishers');

    Route::get('scaleImages', 'ImageController@scaleImages');
    Route::post('deleteBookFromAuthor', 'AuthorController@deleteBookFromAuthor');
    Route::post('editBookFromAuthor', 'AuthorController@editBookFromAuthor');
    Route::post('updateBookFromAuthorTitle', 'AuthorController@updateBookFromAuthorTitle');
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