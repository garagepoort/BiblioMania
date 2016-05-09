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

BookCreationPage.setPublisher = function (publisher) {
    element(by.id('book-publisher')).clear().sendKeys(publisher);
    return this;
};

BookCreationPage.setCountry = function (country) {
    element(by.model('model.country')).clear().sendKeys(country);
    return this;
};

BookCreationPage.setPublicationDate = function (day, month, year) {
    var publicationDir = element(by.model('model.publicationDate'));
    publicationDir.element(by.model('dateModel.day')).clear().sendKeys(day);
    publicationDir.element(by.model('dateModel.month')).clear().sendKeys(month);
    publicationDir.element(by.model('dateModel.year')).clear().sendKeys(year);
    return this;
};

BookCreationPage.openSelectAuthor = function () {
    element(by.id('book-select-author')).click();
    return this;
};

BookCreationPage.assertAuthorName = function (firstname, lastname) {
    expect(element(by.id('book-author-name-label')).getText()).toEqual(firstname + ' ' + lastname);
    return this;
};

BookCreationPage.saveBook = function (summary) {
    element(by.id('book-save-button')).click();
    return this;
};





module.exports = BookCreationPage;