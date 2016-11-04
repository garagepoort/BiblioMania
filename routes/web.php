<?php

//USER
use Illuminate\Support\Facades\Response;

Route::group(array('middleware' => ['auth']), function () {

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

    Route::get('books', 'BookController@getBooks')->middleware('permission:READ_BOOKS');
    Route::post('books', 'BookController@createBook')->middleware('permission:CREATE_BOOK');
    Route::put('books', 'BookController@updateBook')->middleware('permission:UPDATE_BOOK');
    Route::delete('books/{id}', 'BookController@deleteBook')->middleware('permission:DELETE_BOOK');
    Route::post('books/search-all-books', 'BookController@searchAllBooks')->middleware('permission:READ_BOOKS');
    Route::post('books/search-other-books', 'BookController@searchOtherBooks')->middleware('permission:READ_BOOKS');
    Route::post('books/search-my-books', 'BookController@searchMyBooks')->middleware('permission:READ_BOOKS');
    Route::post('books/search-wishlist', 'BookController@searchWishlist')->middleware('permission:READ_BOOKS');
    Route::get('books/{id}', 'BookController@getFullBook')->middleware('permission:READ_BOOKS');
    Route::put('books/{id}/authors', 'BookController@linkAuthorToBook')->middleware('permission:UPDATE_BOOK');
    Route::put('books/{id}/unlink-author', 'BookController@unlinkAuthorFromBook')->middleware('permission:UPDATE_BOOK');

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

    Route::put('oeuvre', 'OeuvreController@updateOeuvreItem')->middleware('permission:UPDATE_OEUVRE_ITEM');
    Route::get('oeuvre/{id}', 'OeuvreController@getOeuvreItem')->middleware('permission:READ_OEUVRE_ITEM');
    Route::delete('oeuvre/{id}', 'OeuvreController@deleteOeuvreItem')->middleware('permission:DELETE_OEUVRE_ITEM');
    Route::get('oeuvre/by-book/{id}', 'OeuvreController@getOeuvreByBook')->middleware('permission:READ_OEUVRE_ITEM');
    Route::post('oeuvre/create-items', 'OeuvreController@saveOeuvreItemsToAuthor')->middleware('permission:CREATE_OEUVRE_ITEM');
    Route::get('oeuvre/{id}/books', 'OeuvreController@getOeuvreItemLinkedBooks')->middleware('permission:READ_OEUVRE_ITEM');
    Route::post('oeuvre/{id}/books', 'OeuvreController@linkBookToOeuvreItem')->middleware('permission:LINK_OEUVRE_ITEM');
    Route::put('oeuvre/{id}/unlink-book', 'OeuvreController@deleteBookFromOeuvreItem')->middleware('permission:UNLINK_OEUVRE_ITEM');

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
    Route::delete('publishers/{id}', 'PublisherController@deletePublisher');
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
Route::group(array('middleware' => 'admin'), function () {
});

//LOCAL
Route::group(array('middleware' => 'localCallOnly'), function () {
    //google API
    Route::get('createSpriteForBooks', 'ImageController@createSpriteForBooks');
    Route::get('createSpriteForAuthors', 'ImageController@createSpriteForAuthors');
    Route::get('search/populate', 'ElasticSearchController@index');
    Route::get('search/clear', 'ElasticSearchController@clear');
    Route::get('dataset/reset', 'DatasetController@resetDatabase');
    Route::get('dataset/{datasetId}', 'DatasetController@executeDataset');
});


//ALL
Route::get('login', 'DefaultLoginController@getLoginPage');
Route::post('login', 'DefaultLoginController@doLogin');
Route::get('changeLanguage/{lang}', 'LanguageController@changeLanguage');

Route::post('users', 'UserController@createUser');
Route::get('createUser', 'UserController@goToCreateUser');

//HOME
Route::get('/', 'HomeController@goHome');
