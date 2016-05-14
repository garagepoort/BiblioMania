describe('user.can.create.first.print.info', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var firstPrintInfoDetails = require('../pages/FirstPrintInfoDetails');
    var firstPrintInfoCreationPage = require('../pages/FirstPrintInfoCreationPage');
    var loginPage = require('../pages/LoginPage');

    var TITLE = 'title';
    var SUBTITLE = 'subtitle';
    var ISBN = '1234567890123';
    var PUBLISHER = 'publisher';
    var COUNTRY = 'Frankrijk';
    var PUBLICATION_DATE = '4-3-2000';
    var LANGUAGE = 'Engels';

    function initializeData() {
        return dataSetService.initialise('user.can.create.first.print.info').then(function (body) {
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
            .navigateTo(data.bookId)
            .assertNoFirstPrintInfoMessagePresent(true)
            .clickOnCreateFirstPrintInfo();

        firstPrintInfoCreationPage
            .assertOnPage(data.bookId)
            .setTitle(TITLE)
            .setSubtitle(SUBTITLE)
            .setIsbn(ISBN)
            .setPublisher(PUBLISHER)
            .setPublicationDate(4,3,2000)
            .setCountry(COUNTRY)
            .selectLanguage(1)
            .saveFirstPrintInfo();

        bookDetailsPage
            .assertOnPage(data.bookId)
            .assertNoFirstPrintInfoMessagePresent(false);

        firstPrintInfoDetails
            .assertTitle(TITLE)
            .assertSubtitle(SUBTITLE)
            .assertIsbn(ISBN)
            .assertPublisher(PUBLISHER)
            .assertPublicationDate(PUBLICATION_DATE)
            .assertLanguage(LANGUAGE)
            .assertCountry(COUNTRY);
    });
});
