var Navigator = require('../Navigator');

var BookDetailsPage = {
    url: '/#/book-details'
};

BookDetailsPage.navigateTo = function (bookId) {
    Navigator.navigateTo(BookDetailsPage.url + '/' + bookId);
    return this;
};

BookDetailsPage.clickOnCreateFirstPrintInfo = function (bookId) {
    element(by.id('create-first-print-info-button')).click();
    return this;
};

BookDetailsPage.assertOnPage = function (bookId) {
    Navigator.assertOnPage(BookDetailsPage.url + '/' + bookId);
    return this;
};

BookDetailsPage.assertNoFirstPrintInfoMessagePresent = function (present) {
    expect(element(by.id('no-first-print-info-message')).isPresent()).toBe(present);
    return this;
};

BookDetailsPage.assertTitle = function (title) {
    expect(element(by.id('book-title-label')).getText()).toEqual(title);
    return this;
};

BookDetailsPage.assertSubtitle = function (subtitle) {
    expect(element(by.id('book-subtitle-label')).getText()).toEqual(subtitle);
    return this;
};

BookDetailsPage.assertIsbn = function (isbn) {
    expect(element(by.id('book-isbn-label')).getText()).toEqual(isbn);
    return this;
};

BookDetailsPage.assertPublisher = function (Publisher) {
    expect(element(by.id('book-publisher-label')).getText()).toEqual(Publisher);
    return this;
};

BookDetailsPage.assertPublicationDate = function (publicationDate) {
    expect(element(by.id('book-publication-date-label')).getText()).toEqual(publicationDate);
    return this;
};

BookDetailsPage.assertLanguage = function (language) {
    expect(element(by.id('book-language-label')).getText()).toEqual(language);
    return this;
};

BookDetailsPage.assertCountry = function (country) {
    expect(element(by.id('book-country-label')).getText()).toEqual(country);
    return this;
};

BookDetailsPage.assertGenre = function (genre) {
    expect(element(by.id('book-genre-label')).getText()).toEqual(genre);
    return this;
};

BookDetailsPage.assertPrint = function (print) {
    expect(element(by.id('book-print-label')).getText()).toEqual(print);
    return this;
};

BookDetailsPage.assertPages = function (pages) {
    expect(element(by.id('book-pages-label')).getText()).toEqual(pages);
    return this;
};

BookDetailsPage.assertTranslator = function (translator) {
    expect(element(by.id('book-translator-label')).getText()).toEqual(translator);
    return this;
};

BookDetailsPage.assertRetailPrice = function (retailPrice) {
    expect(element(by.id('book-retail-price-label')).getText()).toEqual(retailPrice);
    return this;
};

BookDetailsPage.assertBookSerie = function (serie) {
    expect(element(by.id('book-serie-label')).getText()).toEqual(serie);
    return this;
};

BookDetailsPage.assertPublisherSerie = function (publisherSerie) {
    expect(element(by.id('book-publisher-serie-label')).getText()).toEqual(publisherSerie);
    return this;
};

BookDetailsPage.assertContainsAuthor = function (bookId, authorId, authorFirstname, authorLastname) {
    expect(element(by.id('author-name-label-' + bookId + '-' + authorId)).getText()).toEqual(authorFirstname + ' ' + authorLastname);
    return this;
};


module.exports = BookDetailsPage;