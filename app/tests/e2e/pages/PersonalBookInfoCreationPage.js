var Navigator = require('../Navigator');
var ComboBoxComponent = require('../ComboBoxComponent');

var PersonalBookInfoCreationPage = {
    url: '/#/create-personal-book-info',
    editUrl: '/#/edit-personal-book-info'
};

PersonalBookInfoCreationPage.navigateTo = function (bookId) {
    Navigator.navigateTo(PersonalBookInfoCreationPage.url + '/' + bookId);
    return this;
};

PersonalBookInfoCreationPage.assertOnPage = function (bookId) {
    Navigator.assertOnPage(PersonalBookInfoCreationPage.url + '/' + bookId);
    return this;
};

PersonalBookInfoCreationPage.assertOnEditPage = function (bookId) {
    Navigator.assertOnPage(PersonalBookInfoCreationPage.editUrl + '/' + bookId);
    return this;
};

PersonalBookInfoCreationPage.assertNotInCollectionPanelVisible = function (visible) {
    expect(element(by.id('not-in-collection-panel')).isDisplayed()).toBe(visible);
    return this;
};

PersonalBookInfoCreationPage.assertInCollectionPanelVisible = function (visible) {
    expect(element(by.id('in-collection-panel')).isDisplayed()).toBe(visible);
    return this;
};

PersonalBookInfoCreationPage.assertBuyInfoPanelVisible = function (visible) {
    expect(element(by.id('buy-info-panel')).isDisplayed()).toBe(visible);
    return this;
};

PersonalBookInfoCreationPage.assertGiftInfoPanelVisible = function (visible) {
    expect(element(by.id('gift-info-panel')).isDisplayed()).toBe(visible);
    return this;
};

PersonalBookInfoCreationPage.clickOnBuyInfo = function () {
    element(by.id('buy-info-button')).click();
    return this;
};

PersonalBookInfoCreationPage.clickOnGiftInfo = function () {
    element(by.id('gift-info-button')).click();
    return this;
};

PersonalBookInfoCreationPage.setSold = function () {
    element(by.id('sold-button')).click();
    return this;
};

PersonalBookInfoCreationPage.setBorrowed = function () {
    element(by.id('borrowed-button')).click();
    return this;
};

PersonalBookInfoCreationPage.setLost = function () {
    element(by.id('lost-button')).click();
    return this;
};

PersonalBookInfoCreationPage.setBuyDate = function (date) {
    element(by.id('buy-date-input')).clear().sendKeys(date);
    return this;
};

PersonalBookInfoCreationPage.setBuyPrice = function (currencyIndex, amount) {
    ComboBoxComponent.selectOptionByIndex('buy-price-currency', currencyIndex);
    element(by.id('buy-price-amount')).clear().sendKeys(amount);
    return this;
};

PersonalBookInfoCreationPage.setBuyCity = function (city) {
    element(by.id('buy-city-input')).clear().sendKeys(city);
    return this;
};

PersonalBookInfoCreationPage.setBuyCountry = function (country) {
    element(by.id('buy-country-input')).clear().sendKeys(country);
    return this;
};

PersonalBookInfoCreationPage.setBuyShop = function (shop) {
    element(by.id('buy-shop-input')).clear().sendKeys(shop);
    return this;
};

PersonalBookInfoCreationPage.setBuyReason = function (reason) {
    element(by.id('buy-reason-input')).clear().sendKeys(reason);
    return this;
};

PersonalBookInfoCreationPage.setGiftReason = function (reason) {
    element(by.id('gift-reason-input')).clear().sendKeys(reason);
    return this;
};

PersonalBookInfoCreationPage.setGiftFrom = function (from) {
    element(by.id('gift-from-input')).clear().sendKeys(from);
    return this;
};

PersonalBookInfoCreationPage.setGiftDate = function (date) {
    element(by.id('gift-date-input')).clear().sendKeys(date);
    return this;
};

PersonalBookInfoCreationPage.setGiftOccasion = function (occasion) {
    element(by.id('gift-occasion-input')).clear().sendKeys(occasion);
    return this;
};

PersonalBookInfoCreationPage.toggleInCollection = function () {
    element(by.id('in-collection-checkbox')).click();
    return this;
};

PersonalBookInfoCreationPage.save = function () {
    element(by.id('save-button')).click();
    return this;
};

module.exports = PersonalBookInfoCreationPage;