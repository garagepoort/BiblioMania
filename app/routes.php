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

    Route::get('loggedInUser', 'UserController@getLoggedInUser');
    Route::get('users/{id}/wishlist', 'WishlistController@getWishListForUser');
    Route::post('wishlist', 'WishlistController@addBookToWishlist');
    Route::put('wishlist/remove-book', 'WishlistController@removeBookFromWishlist');

    Route::get('chart-configurations/xproperties', 'ChartConfigurationController@getXProperties');
    Route::get('chart-configurations', 'ChartConfigurationController@getChartConfigurations');
    Route::get('chart-configurations/{id}', 'ChartConfigurationController@getChartConfiguration');
    Route::post('chart-configurations', 'ChartConfigurationController@createChartConfiguration');
    Route::put('chart-configurations', 'ChartConfigurationController@updateChartConfiguration');
    Route::delete('chart-configurations/{id}', 'ChartConfigurationController@deleteChartConfiguration');
    Route::get('chart-data/{configurationId}', 'ChartConfigurationController@getChartData');

    Route::get('books', 'BookController@getBooks');
    Route::post('books', 'BookController@createBook');
    Route::put('books', 'BookController@updateBook');
    Route::post('books/search-all-books', 'BookController@searchAllBooks');
    Route::post('books/search-other-books', 'BookController@searchOtherBooks');
    Route::post('books/search-my-books', 'BookController@searchMyBooks');
    Route::post('books/search-wishlist', 'BookController@searchWishlist');
    Route::get('books/{id}', 'BookController@getFullBook');
    Route::delete('books/{id}', 'BookController@deleteBook');
    Route::put('books/{id}/authors', 'BookController@linkAuthorToBook');
    Route::put('books/{id}/unlink-author', 'BookController@unlinkAuthorFromBook');

    Route::get('bookFilters', 'BookController@getFilters');
    Route::get('chartFilters', 'ChartConfigurationController@getFilters');
    Route::get('mostUsedBookFilters', 'BookController@getMostUsedFilters');
    Route::get('tags', 'TagController@getTags');
    Route::get('countries', 'CountryController@getCountries');
    Route::get('shops', 'ShopController@getShops');
    Route::get('languages', 'LanguageController@getLanguages');

    Route::get('publisher-series', 'PublisherSerieController@getPublisherSeries');
    Route::put('publisher-series', 'PublisherSerieController@updateSerie');
    Route::delete('publisher-series/{id}', 'PublisherSerieController@deleteSerie');
    Route::post('publisher-series/{id}/books', 'PublisherSerieController@addBookToSerie');
    Route::put('publisher-series/{id}/remove-book', 'PublisherSerieController@removeBookFromSerie');

    Route::get('series', 'SerieController@getSeries');
    Route::put('series', 'SerieController@updateSerie');
    Route::delete('series/{id}', 'SerieController@deleteSerie');
    Route::post('series/{id}/books', 'SerieController@addBookToSerie');
    Route::put('series/{id}/remove-book', 'SerieController@removeBookFromSerie');

    Route::get('firstprints', 'FirstPrintInfoController@getAllFirstPrintInfos');
    Route::put('firstprints', 'FirstPrintInfoController@updateFirstPrintInfo');
    Route::post('firstprints', 'FirstPrintInfoController@createFirstPrintInfo');
    Route::get('firstprints/{id}', 'FirstPrintInfoController@getFirstPrintInfo');
    Route::post('firstprints/{id}/books', 'FirstPrintInfoController@linkBookToFirstPrintInfo');

    Route::put('oeuvre', 'OeuvreController@updateOeuvreItem');
    Route::get('oeuvre/{id}', 'OeuvreController@getOeuvreItem');
    Route::delete('oeuvre/{id}', 'OeuvreController@deleteOeuvreItem');
    Route::get('oeuvre/by-book/{id}', 'OeuvreController@getOeuvreByBook');
    Route::post('oeuvre/create-items', 'OeuvreController@saveOeuvreItemsToAuthor');
    Route::get('oeuvre/{id}/books', 'OeuvreController@getOeuvreItemLinkedBooks');
    Route::post('oeuvre/{id}/books', 'OeuvreController@linkBookToOeuvreItem');
    Route::put('oeuvre/{id}/unlink-book', 'OeuvreController@deleteBookFromOeuvreItem');

    Route::post('reading-dates', 'ReadingDateController@createReadingDate');
    Route::put('reading-dates', 'ReadingDateController@updateReadingDate');
    Route::delete('reading-dates/{id}', 'ReadingDateController@deleteReadingDate');

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

    Route::get('publishers', 'PublisherController@getPublishers');
    Route::get('publishers/{id}/series', 'PublisherController@getPublisherSeries');
    Route::get('publishers/{id}/books', 'PublisherController@getPublisherBooks');

    Route::get('genres', 'GenreController@getGenres');

    Route::get('getBooksList', 'BookController@getBooksList');
    Route::get('getDraftBooksList', 'BookController@getDraftBooksList');
    Route::get('getFullBook', 'BookController@getFullBook');
    Route::post('deleteBook', 'BookController@deleteBook');


    Route::get('logOut', 'DefaultLoginController@logOut');

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
});

//LOCAL
Route::group(array('before' => 'localCallOnly'), function () {
    //google API
    Route::get('createSpriteForBooks', 'ImageController@createSpriteForBooks');
    Route::get('createSpriteForAuthors', 'ImageController@createSpriteForAuthors');
    Route::get('importBooks', 'BookImportController@importBooks');
    Route::get('search/populate', 'ElasticSearchController@index');
    Route::get('search/clear', 'ElasticSearchController@clear');
    Route::get('dataset/reset', 'DatasetController@resetDatabase');
    Route::get('dataset/{datasetId}', 'DatasetController@executeDataset');
});


//ALL
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
