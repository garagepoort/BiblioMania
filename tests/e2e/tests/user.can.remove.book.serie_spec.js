describe('user.can.remove.book.serie', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var bookSeriesPage = require('../pages/BookSeriesPage');
    var loginPage = require('../pages/LoginPage');
    var confirmationModalPage = require('../pages/ConfirmationModalPage');

    function initializeData() {
        return dataSetService.initialise('user.can.remove.book.serie').then(function (body) {
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

    it('delete serie button visible when serie has no books', function () {
        loginPage.login();

        bookSeriesPage
            .navigateTo()
            .assertSerieInList(data.serie1Id, true)
            .assertSerieInList(data.serie2Id, true)
            .assertDeleteSerieButtonVisible(data.serie1Id, false)
            .assertDeleteSerieButtonVisible(data.serie2Id, true)
            .clickOnDeleteSerieButton(data.serie2Id);

        confirmationModalPage
            .assertOnModal()
            .clickYes();

        bookSeriesPage
            .assertSerieInList(data.serie1Id, true)
            .assertSerieInList(data.serie2Id, false);
    });
});
