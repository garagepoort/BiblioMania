var Navigator = require('../Navigator');
var ComboBoxComponent = require('../ComboBoxComponent');

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

BookCreationPage.setPrint = function (print) {
    element(by.model('model.print')).clear().sendKeys(print);
    return this;
};

BookCreationPage.setPages = function (pages) {
    element(by.model('model.pages')).clear().sendKeys(pages);
    return this;
};

BookCreationPage.setTranslator = function (translator) {
    element(by.model('model.translator')).clear().sendKeys(translator);
    return this;
};

BookCreationPage.setBookSerie = function (serie) {
    element(by.model('model.serie')).clear().sendKeys(serie);
    return this;
};

BookCreationPage.setPublisherSerie = function (serie) {
    element(by.model('model.publisherSerie')).clear().sendKeys(serie);
    return this;
};

BookCreationPage.setRetailPrice = function (currency, amount) {
    ComboBoxComponent.selectOptionByIndex('book-retail-price-currency', currency);
    element(by.model('model.retailPrice.amount')).clear().sendKeys(amount);
    return this;
};

BookCreationPage.selectLanguage = function (languageIndex) {
    ComboBoxComponent.selectOptionByIndex('book-language', languageIndex);
    return this;
};

BookCreationPage.openGenreBranch = function (genre) {
    element(by.id('branch-click-' + genre)).click();
    return this;
};

BookCreationPage.selectGenre = function (genre) {
    element(by.id(genre)).click();
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

BookCreationPage.saveBook = function () {
    element(by.id('book-save-button')).click();
    return this;
};





module.exports = BookCreationPage;