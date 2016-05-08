var AuthorSelectionModalPage = {
    modalId: 'author-selection-modal'
};

AuthorSelectionModalPage.assertOnModal = function () {
    expect(element(by.id(AuthorSelectionModalPage.modalId)).isDisplayed()).toBe(true);
    return this;
};

AuthorSelectionModalPage.assertNotOnModal = function () {
    expect(element(by.id(AuthorSelectionModalPage.modalId)).isPresent()).toBe(false);
    return this;
};

module.exports = AuthorSelectionModalPage;