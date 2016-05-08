var Navigator = require('../Navigator');

var BookCreationPage = {
    url: '/#/create-book'
};

BookCreationPage.navigateTo = function () {
    Navigator.navigateTo(BookCreationPage.url);
    return this;
};

BookCreationPage.assertOnPage = function(){
    Navigator.assertOnPage(BookCreationPage.url);
    return this;
};

BookCreationPage.setTitle = function (title) {
    element(by.id('book-title')).clear().sendKeys(title);
    return this;
};


BookCreationPage.setSubtitle = function (subtitle) {
    element(by.id('book-subtitle')).clear().sendKeys(subtitle);
    return this;
};

BookCreationPage.setIsbn = function (isbn) {
    element(by.id('book-isbn')).clear().sendKeys(isbn);
    return this;
};

BookCreationPage.setSummary = function (summary) {
    element(by.id('book-summary')).clear().sendKeys(summary);
    return this;
};

BookCreationPage.openSelectAuthor = function () {
    element(by.id('book-select-author')).click();
    return this;
};

BookCreationPage.saveBook = function (summary) {
    element(by.id('book-save-button')).click();
    return this;
};





module.exports = BookCreationPage;