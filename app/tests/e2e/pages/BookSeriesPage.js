var Navigator = require('../Navigator');

var BookSeriesPage = {
    url: '/#/series'
};

BookSeriesPage.navigateTo = function () {
    Navigator.navigateTo(BookSeriesPage.url);
    return this;
};

BookSeriesPage.assertOnPage = function () {
    Navigator.assertOnPage(BookSeriesPage.url);
    return this;
};

BookSeriesPage.assertSerieInList = function (serieId, inList) {
    expect(element(by.id('serie-' + serieId)).isPresent()).toBe(inList);
    return this;
};

BookSeriesPage.assertDeleteSerieButtonVisible = function (serieId, visible) {
    expect(element(by.id('delete-serie-button-' + serieId)).isDisplayed()).toBe(visible);
    return this;
};

BookSeriesPage.clickOnDeleteSerieButton = function (serieId) {
    element(by.id('delete-serie-button-' + serieId)).click();
    return this;
};

module.exports = BookSeriesPage;