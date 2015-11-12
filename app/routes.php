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
    Route::post('books/search', 'BookController@search');
    Route::get('books/{id}', 'BookController@getFullBook');
    Route::get('bookFilters', 'BookController@getFilters');
    Route::get('tags', 'TagController@getTags');

    Route::get('genres', 'GenreController@getGenres');

//  BOOKS
    Route::get('getBooks', 'BookController@getBooks');
    Route::get('getBooksList', 'BookController@getBooksList');
    Route::get('getDraftBooksList', 'BookController@getDraftBooksList');
    Route::get('getFullBook', 'BookController@getFullBook');
    Route::get('searchBooks', 'BookController@searchBooks');
    Route::get('filterBooks', 'BookController@filterBooks');
    Route::post('deleteBook', 'BookController@deleteBook');

    //WIZARD
    Route::get('bookwizard', 'BookStepController@getBookWizard');
    Route::get('bookwizard/step/{step}/{book_id?}', 'BookStepController@getBookWizardModel');
    Route::get('createOrEditBook/step/{step}/{id?}', 'BookStepController@get');
    Route::post('createOrEditBook/step/{step}/{id?}', 'BookStepController@save');

    Route::get('logOut', 'DefaultLoginController@logOut');
    Route::get('importLanguageFirstPrintInfo', 'BookImportController@importLanguageFirstPrintInfo');

//STATISTICS
    Route::get('goToStatistics', 'StatisticsController@goToStatistics');
    Route::get('getBooksPerMonth/{year}', 'StatisticsController@getBooksPerMonth');
    Route::get('getOverviewChart', 'StatisticsController@getOverviewChart');
    Route::get('getBooksPerGenreChart', 'StatisticsController@getBooksPerGenreChart');
    Route::get('getBooksAddedPerYearChart', 'StatisticsController@getBooksAddedPerYearChart');
    Route::get('getBooksReadPerYearChart', 'StatisticsController@getBooksReadPerYearChart');
    Route::get('getBooksAndPublicationDate', 'StatisticsController@getBooksAndPublicationDate');

//  AUTHOR
    Route::get('getAuthor/{id}', 'AuthorController@getAuthor');
    Route::get('getAuthors', 'AuthorController@getAuthors');
    Route::get('editAuthor/{id}', 'AuthorController@goToEditAuthor');
    Route::get('getAuthorsList', 'AuthorController@getAuthorsList');
    Route::get('getOeuvreForAuthor/{id}', 'AuthorController@getOeuvreForAuthor');
    Route::get('getNextAuthors', 'AuthorController@getNextAuthors');
    Route::get('getAuthorsWithOeuvreJson', 'AuthorController@getAuthorsWithOeuvreJson');
    Route::post('editAuthorInList', 'AuthorController@editAuthorInList');
    Route::post('editAuthor', 'AuthorController@editAuthor');
    Route::post('changeAuthorImage', 'AuthorController@changeAuthorImage');

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
    Route::post('saveBookFromAuthors', 'OeuvreController@saveBookFromAuthors');
    Route::post('linkBookToBookFromAuthor', 'OeuvreController@linkBookToBookFromAuthor');
    Route::post('updateBookFromAuthorPublicationYear', 'OeuvreController@updateBookFromAuthorPublicationYear');
    Route::post('editBookFromAuthors', 'OeuvreController@editBookFromAuthors');

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
    return Redirect::to('/');
});
