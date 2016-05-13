describe('user.can.create.first.print.info', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var loginPage = require('../pages/LoginPage');

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

    it('creates firstPrintInfo correct', function () {
        loginPage.login();

        bookDetailsPage.navigateTo(data.bookId);
    });
});
