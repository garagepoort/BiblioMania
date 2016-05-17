var OeuvreItemSelectionModalPage = {
    modalId: 'oeuvre-item-selection-modal'
};

OeuvreItemSelectionModalPage.assertOnModal = function () {
    expect(element(by.id(OeuvreItemSelectionModalPage.modalId)).isDisplayed()).toBe(true);
    return this;
};

OeuvreItemSelectionModalPage.assertNotOnModal = function () {
    expect(element(by.id(OeuvreItemSelectionModalPage.modalId)).isPresent()).toBe(false);
    return this;
};

OeuvreItemSelectionModalPage.selectOeuvreItem = function (authorId, oeuvreItemId) {
    element(by.id('author-' + authorId)).click();
    element(by.id('oeuvre-item-' + oeuvreItemId)).click();
    return this;
};

module.exports = OeuvreItemSelectionModalPage;