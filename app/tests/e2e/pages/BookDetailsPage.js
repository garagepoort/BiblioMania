var Navigator = require('../Navigator');

var BookDetailsPage = {
    url: '/#/book-details'
};

BookDetailsPage.navigateTo = function (bookId) {
    Navigator.navigateTo(BookDetailsPage.url + '/' + bookId);
    return this;
};

BookDetailsPage.assertOnPage = function (bookId) {
    Navigator.assertOnPage(BookDetailsPage.url + '/' + bookId);
    return this;
};


module.exports = BookDetailsPage;