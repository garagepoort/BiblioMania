var BookAuthorsDetails = {};

BookAuthorsDetails.clickOnLinkAuthor = function (bookId) {
    element(by.id('link-author-to-book-button-' + bookId)).click();
    return this;
};

BookAuthorsDetails.clickOnUnlinkAuthor = function (bookId, authorId) {
    element(by.id('unlink-author-from-book-button-' + bookId + '-' + authorId)).click();
    return this;
};

BookAuthorsDetails.assertContainsAuthor = function (bookId, authorId, authorFirstname, authorLastname) {
    expect(element(by.id('author-name-label-' + bookId + '-' + authorId)).getText()).toEqual(authorFirstname + ' ' + authorLastname);
    return this;
};


BookAuthorsDetails.assertDoesNotContainAuthor = function (bookId, authorId) {
    expect(element(by.id('author-name-label-' + bookId + '-' + authorId)).isPresent()).toBe(false);
    return this;
};

module.exports = BookAuthorsDetails;