describe('user.can.link.existing.first.print.info.to.book', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var firstPrintInfoDetails = require('../pages/FirstPrintInfoDetails');
    var firstPrintInfoSelectionModal = require('../pages/FirstPrintInfoSelectionModalPage');
    var loginPage = require('../pages/LoginPage');

    function initializeData() {
        return dataSetService.initialise('user.can.link.existing.first.print.info.to.book').then(function (body) {
            datasetInitialized = true;
            data = body;
            console.log('data: ' + data);
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

    it('creates firstPrintInfo correct', function () {
        loginPage.login();

        bookDetailsPage
            .navigateTo(data.bookId);

        firstPrintInfoDetails
            .assertNoFirstPrintInfoMessagePresent(true)
            .clickOnSelectFirstPrintInfo();

        firstPrintInfoSelectionModal
            .assertOnModal()
            .selectFirstPrintInfo(data.firstPrintInfo.id);

        bookDetailsPage
            .assertOnPage(data.bookId);
        firstPrintInfoDetails
            .assertNoFirstPrintInfoMessagePresent(false);

        firstPrintInfoDetails
            .assertTitle(data.firstPrintInfo.title)
            .assertSubtitle(data.firstPrintInfo.subtitle)
            .assertIsbn(data.firstPrintInfo.isbn)
            .assertPublisher(data.firstPrintInfo.publisher)
            .assertLanguage(data.firstPrintInfo.language)
            .assertCountry(data.firstPrintInfo.country);
    });
});
