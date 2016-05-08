describe('create.book.e2e.test', function () {
    var dataSetService = require('../DataSetService');
    var bookCreationPage = require('../pages/BookCreationPage');
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var loginPage = require('../pages/LoginPage');
    var authorSelectionModalPage = require('../pages/AuthorSelectionModalPage');

    var datasetInitialized = false;
    var data;

    function initializeData() {
        dataSetService.initialise('user.can.create.book').then(function (body) {
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


    it('creates book correctly and redirects to book overview page', function () {
        loginPage.login();
        bookCreationPage
            .navigateTo()
            .setTitle('title')
            .setSubtitle('subtitle')
            .setIsbn('1234567890123')
            .setSummary('summary')
            .openSelectAuthor();

        authorSelectionModalPage.assertOnModal();
    });

});
