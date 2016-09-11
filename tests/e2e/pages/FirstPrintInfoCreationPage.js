var Navigator = require('../Navigator');
var ComboBoxComponent = require('../ComboBoxComponent');

var FirstPrintInfoCreationPage = {
    url: '/#/create-first-print-and-link-to-book'
};

FirstPrintInfoCreationPage.navigateTo = function (bookId) {
    Navigator.navigateTo(FirstPrintInfoCreationPage.url + '/' + bookId);
    return this;
};

FirstPrintInfoCreationPage.assertOnPage = function (bookId) {
    Navigator.assertOnPage(FirstPrintInfoCreationPage.url + '/' + bookId);
    return this;
};

FirstPrintInfoCreationPage.setTitle = function (title) {
    element(by.id('first-print-info-title')).clear().sendKeys(title);
    return this;
};

FirstPrintInfoCreationPage.setSubtitle = function (subtitle) {
    element(by.id('first-print-info-subtitle')).clear().sendKeys(subtitle);
    return this;
};

FirstPrintInfoCreationPage.setIsbn = function (isbn) {
    element(by.id('first-print-info-isbn')).clear().sendKeys(isbn);
    return this;
};

FirstPrintInfoCreationPage.setPublisher = function (publisher) {
    element(by.id('first-print-info-publisher')).clear().sendKeys(publisher);
    return this;
};

FirstPrintInfoCreationPage.setCountry = function (country) {
    element(by.model('model.country')).clear().sendKeys(country);
    return this;
};

FirstPrintInfoCreationPage.selectLanguage = function (languageIndex) {
    ComboBoxComponent.selectOptionByIndex('first-print-info-language', languageIndex);
    return this;
};

FirstPrintInfoCreationPage.setPublicationDate = function (day, month, year) {
    var publicationDir = element(by.model('model.publicationDate'));
    publicationDir.element(by.model('dateModel.day')).clear().sendKeys(day);
    publicationDir.element(by.model('dateModel.month')).clear().sendKeys(month);
    publicationDir.element(by.model('dateModel.year')).clear().sendKeys(year);
    return this;
};

FirstPrintInfoCreationPage.saveFirstPrintInfo = function () {
    element(by.id('first-print-info-save-button')).click();
    return this;
};


module.exports = FirstPrintInfoCreationPage;