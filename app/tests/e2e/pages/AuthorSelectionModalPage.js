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

AuthorSelectionModalPage.selectAuthor = function (authorId) {
    element(by.id('author-select-' + authorId)).click();
    return this;
};

module.exports = AuthorSelectionModalPage;