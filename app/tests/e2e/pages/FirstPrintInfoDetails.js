var Navigator = require('../Navigator');

var FirstPrintInfoDetails = {
    url: '/#/first-print-info-details'
};

FirstPrintInfoDetails.clickOnCreateFirstPrintInfo = function () {
    element(by.id('create-first-print-info-button')).click();
    return this;
};

FirstPrintInfoDetails.clickOnSelectFirstPrintInfo = function () {
    element(by.id('select-first-print-info-button')).click();
    return this;
};

FirstPrintInfoDetails.assertNoFirstPrintInfoMessagePresent = function (present) {
    expect(element(by.id('no-first-print-info-message')).isPresent()).toBe(present);
    return this;
};


FirstPrintInfoDetails.assertTitle = function (title) {
    expect(element(by.id('first-print-info-title-label')).getText()).toEqual(title);
    return this;
};

FirstPrintInfoDetails.assertSubtitle = function (subtitle) {
    expect(element(by.id('first-print-info-subtitle-label')).getText()).toEqual(subtitle);
    return this;
};

FirstPrintInfoDetails.assertIsbn = function (isbn) {
    expect(element(by.id('first-print-info-isbn-label')).getText()).toEqual(isbn);
    return this;
};

FirstPrintInfoDetails.assertPublisher = function (Publisher) {
    expect(element(by.id('first-print-info-publisher-label')).getText()).toEqual(Publisher);
    return this;
};

FirstPrintInfoDetails.assertPublicationDate = function (publicationDate) {
    expect(element(by.id('first-print-info-publication-date-label')).getText()).toEqual(publicationDate);
    return this;
};

FirstPrintInfoDetails.assertCountry = function (country) {
    expect(element(by.id('first-print-info-country-label')).getText()).toEqual(country);
    return this;
};

FirstPrintInfoDetails.assertLanguage = function (language) {
    expect(element(by.id('first-print-info-language-label')).getText()).toEqual(language);
    return this;
};

module.exports = FirstPrintInfoDetails;