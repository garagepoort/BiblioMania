describe('user.can.add.and.remove.reading.date', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var bookReadingDatesDetails = require('../pages/BookReadingDatesDetails');
    var readingDateModalPage = require('../pages/ReadingDateModalPage');
    var loginPage = require('../pages/LoginPage');
    var confirmationModalPage = require('../pages/ConfirmationModalPage');

    function initializeData() {
        return dataSetService.initialise('user.can.add.and.remove.reading.date').then(function (body) {
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

    it('adds and removes reading date correctly', function () {
        loginPage.loginWithUser('testUser', 'test');

        bookDetailsPage
            .navigateTo(data.bookId)
            .assertReadingDatePanelVisible(true);

        bookReadingDatesDetails.clickOnAddReadingDate();

        var rating = 8;
        var review = 'some review here';
        var date = '01-06-2016';
        readingDateModalPage
            .assertOnModal()
            .setRating(rating)
            .setReview(review)
            .setDate(date)
            .clickSaveButton()
            .assertNotOnModal();

        bookReadingDatesDetails
            .assertReadingDatePresent(1, rating, review, date)
            .clickOnDeleteReadingDate(1);

        confirmationModalPage
            .assertOnModal()
            .clickYes();

        bookReadingDatesDetails
            .assertNoReadingDates();
    });
});
