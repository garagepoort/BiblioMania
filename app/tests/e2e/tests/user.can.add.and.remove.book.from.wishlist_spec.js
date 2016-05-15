describe('user.can.add.and.remove.book.from.wishlist', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var loginPage = require('../pages/LoginPage');

    function initializeData() {
        return dataSetService.initialise('user.can.add.and.remove.book.from.wishlist').then(function (body) {
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

    it('adds and removes correctly', function () {
        loginPage.login();

        bookDetailsPage
            .navigateTo(data.bookId)
            .assertBookOnwishlistMessageDisplayed(false)
            .clickOnAddToWishListButton()
            .assertBookOnwishlistMessageDisplayed(true)
            .clickOnRemoveFromWishListButton()
            .assertBookOnwishlistMessageDisplayed(false);

    });
});
