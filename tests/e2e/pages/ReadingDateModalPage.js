var ReadingDateModalPage = {
    modalId: 'reading-date-modal'
};

ReadingDateModalPage.assertOnModal = function () {
    expect(element(by.id(ReadingDateModalPage.modalId)).isDisplayed()).toBe(true);
    return this;
};

ReadingDateModalPage.assertNotOnModal = function () {
    expect(element(by.id(ReadingDateModalPage.modalId)).isPresent()).toBe(false);
    return this;
};

ReadingDateModalPage.setRating = function (rating) {
    element(by.xpath('//i[@aria-valuetext="' + rating + '"]')).click();
    return this;
};

ReadingDateModalPage.setReview = function (review) {
    element(by.id('review-input')).clear().sendKeys(review);
    return this;
};

ReadingDateModalPage.setDate = function (date) {
    element(by.id('date-input')).clear().sendKeys(date);
    return this;
};

ReadingDateModalPage.clickSaveButton = function () {
    element(by.id('save-button')).click();
    return this;
};

ReadingDateModalPage.clickCancelButton = function () {
    element(by.id('cancel-button')).click();
    return this;
};


module.exports = ReadingDateModalPage;