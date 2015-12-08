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
Route::group(array('before' => 'auth'), function () {

    Route::get('books', 'BookController@getBooks');
    Route::post('books', 'BookController@createBook');
    Route::post('books/search', 'BookController@search');
    Route::get('books/{id}', 'BookController@getFullBook');
    Route::put('books/{id}/authors', 'BookController@linkAuthorToBook');
    Route::put('books/{id}/unlink-author', 'BookController@unlinkAuthorFromBook');

    Route::get('bookFilters', 'BookController@getFilters');
    Route::get('tags', 'TagController@getTags');
    Route::get('countries', 'CountryController@getCountries');
    Route::get('languages', 'LanguageController@getLanguages');

    Route::get('firstprints', 'FirstPrintController@getAllFirstPrintInfos');
    Route::put('firstprints', 'FirstPrintController@updateFirstPrintInfo');
    Route::post('firstprints', 'FirstPrintController@createFirstPrintInfo');
    Route::get('firstprints/{id}', 'FirstPrintController@getFirstPrintInfo');
    Route::post('firstprints/{id}/books', 'FirstPrintController@linkBookToFirstPrintInfo');

    Route::put('oeuvre', 'OeuvreController@updateOeuvreItem');
    Route::get('oeuvre/{id}', 'OeuvreController@getOeuvreItem');
    Route::delete('oeuvre/{id}', 'OeuvreController@deleteOeuvreItem');
    Route::get('oeuvre/by-book/{id}', 'OeuvreController@getOeuvreByBook');
    Route::post('oeuvre/create-items', 'OeuvreController@saveOeuvreItemsToAuthor');
    Route::get('oeuvre/{id}/books', 'OeuvreController@getOeuvreItemLinkedBooks');
    Route::post('oeuvre/{id}/books', 'OeuvreController@linkBookToOeuvreItem');
    Route::put('oeuvre/{id}/unlink-book', 'OeuvreController@deleteBookFromOeuvreItem');

    Route::get('authors/by-book/{id}', 'AuthorController@getAuthorByBook');
    Route::get('authors', 'AuthorController@getAllAuthors');
    Route::get('authors/{id}', 'AuthorController@getAuthor');
    Route::post('authors', 'AuthorController@createAuthor');
    Route::put('authors', 'AuthorController@updateAuthor');
    Route::get('authors/{id}/books', 'BookController@getBooksByAuthor');
    Route::get('authors/{id}/oeuvre', 'OeuvreController@getOeuvreFromAuthor');

    Route::post('personalbookinfos', 'PersonalBookInfoController@create');
    Route::put('personalbookinfos', 'PersonalBookInfoController@update');
    Route::get('personalbookinfos/{id}', 'PersonalBookInfoController@get');
    Route::get('personalbookinfos/{id}/readingdates', 'PersonalBookInfoController@getReadingDates');
    Route::post('personalbookinfos/{id}/readingdates', 'PersonalBookInfoController@addReadingDate');
    Route::put('personalbookinfos/{id}/delete-reading-date', 'PersonalBookInfoController@deleteReadingDate');

    Route::get('publishers', 'PublisherController@getPublishers');
    Route::get('publishers/{id}/series', 'PublisherController@getPublisherSeries');

    Route::get('genres', 'GenreController@getGenres');

//  BOOKS
    Route::get('getBooks', 'BookController@getBooks');
    Route::get('getBooksList', 'BookController@getBooksList');
    Route::get('getDraftBooksList', 'BookController@getDraftBooksList');
    Route::get('getFullBook', 'BookController@getFullBook');
    Route::get('searchBooks', 'BookController@searchBooks');
    Route::get('filterBooks', 'BookController@filterBooks');
    Route::post('deleteBook', 'BookController@deleteBook');


    Route::get('logOut', 'DefaultLoginController@logOut');
    Route::get('importLanguageFirstPrintInfo', 'BookImportController@importLanguageFirstPrintInfo');

//    COUNTRY
    Route::get('getCountryList', 'CountryController@getCountryList');
    Route::post('editCountry', 'CountryController@editCountry');
    Route::post('deleteCountry', 'CountryController@deleteCountry');
    Route::post('mergeCountries', 'CountryController@mergeCountries');

    Route::get('scaleImages', 'ImageController@scaleImages');
});

//  API
Route::group(['prefix' => 'api'], function () {
    Route::resource('books', 'BookApiController', ['only' => ['index']]);
    Route::get('image/book/{id}', 'ImageController@getBookImage');
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('users', 'AuthenticateController@users');
});


//ADMIN
Route::group(array('before' => 'admin'), function () {
    //google API
    Route::get('googleAuthentication', 'Oauth2_Controller@doGoogleAuthentication');
    Route::get('askForGoogleAuthentication', 'Oauth2_Controller@askForGoogleAuthentication');
    Route::get('uploadFile', 'Oauth2_Controller@uploadFile');
    Route::get('admin', 'AdminController@goToAdminPagina');
});

//LOCAL
Route::group(array('before' => 'localCallOnly'), function () {
    //google API
    Route::get('createSpriteForBooks', 'ImageController@createSpriteForBooks');
    Route::get('createSpriteForAuthors', 'ImageController@createSpriteForAuthors');
    Route::get('importBooks', 'BookImportController@importBooks');
});


//ALL
Route::get('backupDatabase/{username?}/{password?}', 'AdminController@backupDatabase');
Route::get('login', 'DefaultLoginController@getLoginPage');
Route::post('login', 'DefaultLoginController@doLogin');
Route::get('changeLanguage/{lang}', 'LanguageController@changeLanguage');

Route::post('createUser', 'UserController@createUser');
Route::get('createUser', 'UserController@goToCreateUser');

//HOME
Route::get('/', 'HomeController@goHome');

App::missing(function ($exception) {
    return Response::make('', 404);
});
