var PersonalBookInfoDetails = {};

PersonalBookInfoDetails.clickOnCreatePersonalBookInfo = function () {
    element(by.id('create-personal-book-info-button')).click();
    return this;
};

PersonalBookInfoDetails.clickOnEditPersonalBookInfo = function () {
    element(by.id('edit-personal-book-info-button')).click();
    return this;
};

PersonalBookInfoDetails.assertReasonNotInCollection = function (reason) {
    expect(element(by.id('reason-not-in-collection-label')).getText()).toEqual(reason);
    return this;
};

PersonalBookInfoDetails.assertInCollection = function (inCollection) {
    var inC = inCollection ? 'Ja' : 'Nee';
    expect(element(by.id('in-collection-label')).getText()).toEqual(inC);
    return this;
};

PersonalBookInfoDetails.assertBuyDate = function (date) {
    expect(element(by.id('buy-date-label')).getText()).toEqual(date);
    return this;
};

PersonalBookInfoDetails.assertBuyPrice = function (currency, amount) {
    expect(element(by.id('buy-price-label')).getText()).toEqual(currency + ' ' + amount);
    return this;
};

PersonalBookInfoDetails.assertBuyShop = function (shop) {
    expect(element(by.id('buy-shop-label')).getText()).toEqual(shop);
    return this;
};

PersonalBookInfoDetails.assertBuyCity = function (city) {
    expect(element(by.id('buy-city-label')).getText()).toEqual(city);
    return this;
};

PersonalBookInfoDetails.assertBuyCountry = function (country) {
    expect(element(by.id('buy-country-label')).getText()).toEqual(country);
    return this;
};

PersonalBookInfoDetails.assertBuyReason = function (reason) {
    expect(element(by.id('buy-reason-label')).getText()).toEqual(reason);
    return this;
};

PersonalBookInfoDetails.assertGiftDate = function (date) {
    expect(element(by.id('gift-date-label')).getText()).toEqual(date);
    return this;
};

PersonalBookInfoDetails.assertGiftFrom = function (from) {
    expect(element(by.id('gift-from-label')).getText()).toEqual(from);
    return this;
};

PersonalBookInfoDetails.assertGiftReason = function (reason) {
    expect(element(by.id('gift-reason-label')).getText()).toEqual(reason);
    return this;
};

PersonalBookInfoDetails.assertGiftOccasion = function (occasion) {
    expect(element(by.id('gift-occasion-label')).getText()).toEqual(occasion);
    return this;
};





module.exports = PersonalBookInfoDetails;