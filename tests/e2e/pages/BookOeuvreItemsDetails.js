var BookOeuvreItemsDetails = {};

BookOeuvreItemsDetails.assertNotLinkedToOeuvreItemMessagePresent = function (present) {
    expect(element(by.id('book-not-linked-to-oeuvre-item-message')).isPresent()).toBe(present);
    return this;
};

BookOeuvreItemsDetails.clickOnLinkOeuvreItemButton = function () {
    element(by.id('link-oeuvre-item-button')).click();
    return this;
};

BookOeuvreItemsDetails.clickOnUnlinkOeuvreItemButton = function (oeuvreItemId) {
    element(by.id('unlink-oeuvre-item-button-' + oeuvreItemId)).click();
    return this;
};

module.exports = BookOeuvreItemsDetails;