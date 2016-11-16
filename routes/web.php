<?php

//USER
use Illuminate\Support\Facades\Response;

Route::group(array('middleware' => ['auth', 'activated']), function () {

    Route::get('loggedInUser', 'UserController@getLoggedInUser');

    Route::post('wishlist', 'WishlistController@addBookToWishlist')->middleware('permission:LINK_WISHLIST');
    Route::put('wishlist/remove-book', 'WishlistController@removeBookFromWishlist')->middleware('permission:UNLINK_WISHLIST');

    Route::get('chart-configurations/xproperties', 'ChartConfigurationController@getXProperties');
    Route::get('chart-configurations', 'ChartConfigurationController@getChartConfigurations');
    Route::get('chart-configurations/{id}', 'ChartConfigurationController@getChartConfiguration');
    Route::post('chart-configurations', 'ChartConfigurationController@createChartConfiguration');
    Route::put('chart-configurations', 'ChartConfigurationController@updateChartConfiguration');
    Route::delete('chart-configurations/{id}', 'ChartConfigurationController@deleteChartConfiguration');
    Route::get('chart-data/{configurationId}', 'ChartConfigurationController@getChartData');

    Route::get('books', 'BookController@getBooks')->middleware('permission:READ_BOOK');
    Route::post('books', 'BookController@createBook')->middleware('permission:CREATE_BOOK');
    Route::put('books', 'BookController@updateBook')->middleware('permission:UPDATE_BOOK');
    Route::delete('books/{id}', 'BookController@deleteBook')->middleware('permission:DELETE_BOOK');
    Route::post('books/search-all-books', 'BookController@searchAllBooks')->middleware('permission:READ_BOOK');
    Route::post('books/search-other-books', 'BookController@searchOtherBooks')->middleware('permission:READ_BOOK');
    Route::post('books/search-my-books', 'BookController@searchMyBooks')->middleware('permission:READ_BOOK');
    Route::post('books/search-wishlist', 'BookController@searchWishlist')->middleware('permission:READ_BOOK');
    Route::get('books/{id}', 'BookController@getFullBook')->middleware('permission:READ_BOOK');
    Route::put('books/{id}/authors', 'BookController@linkAuthorToBook')->middleware('permission:LINK_AUTHOR');
    Route::put('books/{id}/unlink-author', 'BookController@unlinkAuthorFromBook')->middleware('permission:UNLINK_AUTHOR');

    Route::get('bookFilters', 'BookController@getFilters');
    Route::get('chartFilters', 'ChartConfigurationController@getFilters');
    Route::get('mostUsedBookFilters', 'BookController@getMostUsedFilters');
    Route::get('tags', 'TagController@getTags');
    Route::get('countries', 'CountryController@getCountries');
    Route::get('shops', 'ShopController@getShops');
    Route::get('languages', 'LanguageController@getLanguages');

    Route::get('publisher-series', 'PublisherSerieController@getPublisherSeries')->middleware('permission:READ_SERIE');
    Route::put('publisher-series', 'PublisherSerieController@updateSerie')->middleware('permission:UPDATE_SERIE');
    Route::delete('publisher-series/{id}', 'PublisherSerieController@deleteSerie')->middleware('permission:DELETE_SERIE');
    Route::post('publisher-series/{id}/books', 'PublisherSerieController@addBookToSerie')->middleware('permission:LINK_SERIE');
    Route::put('publisher-series/{id}/remove-book', 'PublisherSerieController@removeBookFromSerie')->middleware('permission:UNLINK_SERIE');

    Route::get('series', 'SerieController@getSeries')->middleware('permission:READ_SERIE');
    Route::put('series', 'SerieController@updateSerie')->middleware('permission:UPDATE_SERIE');
    Route::delete('series/{id}', 'SerieController@deleteSerie')->middleware('permission:DELETE_SERIE');
    Route::post('series/{id}/books', 'SerieController@addBookToSerie')->middleware('permission:LINK_SERIE');
    Route::put('series/{id}/remove-book', 'SerieController@removeBookFromSerie')->middleware('permission:UNLINK_SERIE');;

    Route::get('firstprints', 'FirstPrintInfoController@getAllFirstPrintInfos')->middleware('permission:READ_FIRST_PRINT');
    Route::put('firstprints', 'FirstPrintInfoController@updateFirstPrintInfo')->middleware('permission:UPDATE_FIRST_PRINT');
    Route::post('firstprints', 'FirstPrintInfoController@createFirstPrintInfo')->middleware('permission:CREATE_FIRST_PRINT');
    Route::get('firstprints/{id}', 'FirstPrintInfoController@getFirstPrintInfo')->middleware('permission:READ_FIRST_PRINT');
    Route::post('firstprints/{id}/books', 'FirstPrintInfoController@linkBookToFirstPrintInfo')->middleware('permission:LINK_FIRST_PRINT');

    Route::put('oeuvre', 'OeuvreController@updateOeuvreItem')->middleware('permission:UPDATE_OEUVRE_ITEM');
    Route::get('oeuvre/{id}', 'OeuvreController@getOeuvreItem')->middleware('permission:READ_OEUVRE_ITEM');
    Route::delete('oeuvre/{id}', 'OeuvreController@deleteOeuvreItem')->middleware('permission:DELETE_OEUVRE_ITEM');
    Route::get('oeuvre/by-book/{id}', 'OeuvreController@getOeuvreByBook')->middleware('permission:READ_OEUVRE_ITEM');
    Route::post('oeuvre/create-items', 'OeuvreController@saveOeuvreItemsToAuthor')->middleware('permission:CREATE_OEUVRE_ITEM');
    Route::get('oeuvre/{id}/books', 'OeuvreController@getOeuvreItemLinkedBooks')->middleware('permission:READ_OEUVRE_ITEM');
    Route::post('oeuvre/{id}/books', 'OeuvreController@linkBookToOeuvreItem')->middleware('permission:LINK_OEUVRE_ITEM');
    Route::put('oeuvre/{id}/unlink-book', 'OeuvreController@deleteBookFromOeuvreItem')->middleware('permission:UNLINK_OEUVRE_ITEM');

    Route::post('reading-dates', 'ReadingDateController@createReadingDate')->middleware('permission:CREATE_READING_DATE');
    Route::put('reading-dates', 'ReadingDateController@updateReadingDate')->middleware('permission:UPDATE_READING_DATE');
    Route::delete('reading-dates/{id}', 'ReadingDateController@deleteReadingDate')->middleware('permission:DELETE_READING_DATE');

    Route::get('authors/by-book/{id}', 'AuthorController@getAuthorByBook')->middleware('permission:READ_AUTHOR');
    Route::get('authors', 'AuthorController@getAllAuthors')->middleware('permission:READ_AUTHOR');
    Route::get('authors/{id}', 'AuthorController@getAuthor')->middleware('permission:READ_AUTHOR');
    Route::post('authors', 'AuthorController@createAuthor')->middleware('permission:CREATE_AUTHOR');
    Route::put('authors', 'AuthorController@updateAuthor')->middleware('permission:UPDATE_AUTHOR');
    Route::get('authors/{id}/books', 'BookController@getBooksByAuthor')->middleware('permission:READ_BOOK');
    Route::get('authors/{id}/oeuvre', 'OeuvreController@getOeuvreFromAuthor')->middleware('permission:READ_OEUVRE_ITEM');

    Route::get('personalbookinfos/{id}', 'PersonalBookInfoController@get')->middleware('permission:READ_PERSONAL_BOOK_INFO');
    Route::post('personalbookinfos', 'PersonalBookInfoController@create')->middleware('permission:CREATE_PERSONAL_BOOK_INFO');
    Route::put('personalbookinfos', 'PersonalBookInfoController@update')->middleware('permission:UPDATE_PERSONAL_BOOK_INFO');
    Route::get('personalbookinfos/{id}/readingdates', 'PersonalBookInfoController@getReadingDates')->middleware('permission:READ_READING_DATE');

    Route::get('publishers', 'PublisherController@getPublishers');
    Route::delete('publishers/{id}', 'PublisherController@deletePublisher');
    Route::get('publishers/{id}/series', 'PublisherController@getPublisherSeries');
    Route::get('publishers/{id}/books', 'PublisherController@getPublisherBooks');

    Route::get('genres', 'GenreController@getGenres');

    Route::get('logOut', 'DefaultLoginController@logOut');
});

//  API
Route::group(['prefix' => 'api'], function () {
    Route::resource('books', 'BookApiController', ['only' => ['index']]);
    Route::get('image/book/{id}', 'ImageController@getBookImage');
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('users', 'AuthenticateController@users');
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
Route::post('login', 'DefaultLoginController@doLogin');
Route::post('users', 'UserController@createUser');
Route::get('users/activate/{token}', 'UserActivationController@activateUser')->name('user.activate');

//HOME
Route::get('/', 'HomeController@goHome');
