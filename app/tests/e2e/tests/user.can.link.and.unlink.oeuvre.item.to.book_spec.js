describe('user.can.link.and.unlink.oeuvre.item.to.book', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var confirmationModalPage = require('../pages/ConfirmationModalPage');
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var bookOeuvreItemsDetails = require('../pages/BookOeuvreItemsDetails');
    var oeuvreItemSelectionModal = require('../pages/OeuvreItemSelectionModalPage');
    var loginPage = require('../pages/LoginPage');

    function initializeData() {
        return dataSetService.initialise('user.can.link.and.unlink.oeuvre.item.to.book').then(function (body) {
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
            .navigateTo(data.bookId);

        bookOeuvreItemsDetails
            .assertNotLinkedToOeuvreItemMessagePresent(true)
            .clickOnLinkOeuvreItemButton();

        oeuvreItemSelectionModal
            .assertOnModal()
            .selectOeuvreItem(data.authorId, data.oeuvreItemId)
            .assertNotOnModal();

        bookOeuvreItemsDetails
            .assertNotLinkedToOeuvreItemMessagePresent(false)
            .clickOnUnlinkOeuvreItemButton(data.oeuvreItemId);

        confirmationModalPage
            .assertOnModal()
            .clickNo();

        bookOeuvreItemsDetails
            .assertNotLinkedToOeuvreItemMessagePresent(false);

        bookOeuvreItemsDetails
            .clickOnUnlinkOeuvreItemButton(data.oeuvreItemId);

        confirmationModalPage
            .assertOnModal()
            .clickYes();

        bookOeuvreItemsDetails
            .assertNotLinkedToOeuvreItemMessagePresent(true);

    });
});
