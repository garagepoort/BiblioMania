describe('user.can.link.and.unlink.author.to.book', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var confirmationModalPage = require('../pages/ConfirmationModalPage');
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var bookAuthorsDetails = require('../pages/BookAuthorsDetails');
    var authorSelectionModal = require('../pages/AuthorSelectionModalPage');
    var loginPage = require('../pages/LoginPage');

    function initializeData() {
        return dataSetService.initialise('user.can.link.and.unlink.author.to.book').then(function (body) {
            datasetInitialized = true;
            data = body;
        });
    }

    beforeEach(function (done) {
        if (!datasetInitialized) {
            dataSetService.reset().then(initializeData).finally(done);
        }else{
            done();
        }
    });

    afterEach(function(){
        loginPage.logout();
    });

    it('links and unlinks author correct', function () {
        loginPage.login();

        bookDetailsPage
            .navigateTo(data.bookId);

        bookAuthorsDetails
            .clickOnLinkAuthor(data.bookId);

        authorSelectionModal
            .assertOnModal()
            .selectAuthor(data.authorToLink.id);

        bookDetailsPage
            .assertOnPage(data.bookId);

        bookAuthorsDetails
            .assertContainsAuthor(data.bookId, data.preferredAuthor.id, 'author1_first', 'author1_last')
            .assertContainsAuthor(data.bookId, data.authorToLink.id, 'author2_first', 'author2_last');

        bookAuthorsDetails.
            clickOnUnlinkAuthor(data.bookId, data.authorToLink.id);

        confirmationModalPage
            .assertOnModal()
            .clickNo();

        bookAuthorsDetails
            .assertContainsAuthor(data.bookId, data.preferredAuthor.id, 'author1_first', 'author1_last')
            .assertContainsAuthor(data.bookId, data.authorToLink.id, 'author2_first', 'author2_last');

        bookAuthorsDetails.
            clickOnUnlinkAuthor(data.bookId, data.authorToLink.id);

        confirmationModalPage
            .assertOnModal()
            .clickYes();

        bookAuthorsDetails
            .assertContainsAuthor(data.bookId, data.preferredAuthor.id, 'author1_first', 'author1_last')
            .assertDoesNotContainAuthor(data.bookId, data.authorToLink.id);
    });
});
