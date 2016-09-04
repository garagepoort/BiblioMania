var BookReadingDatesDetails = {};

BookReadingDatesDetails.clickOnAddReadingDate = function () {
    element(by.id('add-reading-date-button')).click();
    return this;
};

BookReadingDatesDetails.clickOnAddReadingDateToday = function () {
    element(by.id('add-reading-date-today-button')).click();
    return this;
};


BookReadingDatesDetails.clickOnDeleteReadingDate = function (index) {
    element(by.id('delete-reading-date-button-' + (index-1))).click();
    return this;
};

BookReadingDatesDetails.assertNoReadingDates = function () {
    element.all(by.css('.reading-date-row')).then(function(items) {
        expect(items.length).toBe(0);
    });
    return this;
};

BookReadingDatesDetails.assertReadingDatePresent = function (index, rating, review, date) {
    index = index-1;
    element(by.id('reading-date-row-' + index)).click();
    element.all(by.css('.glyphicon-star')).then(function(items) {
        expect(items.length).toBe(rating);
    });
    expect(element(by.id('date-' + index)).getText()).toEqual(date);
    expect(element(by.id('review-' + index)).getText()).toEqual(review);
    return this;
};

module.exports = BookReadingDatesDetails;