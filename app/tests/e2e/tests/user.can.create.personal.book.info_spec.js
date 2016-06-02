describe('user.can.create.personal.book.info', function () {
    var dataSetService = require('../DataSetService');

    var datasetInitialized = false;
    var data;
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var personalBookInfoDetails = require('../pages/PersonalBookInfoDetails');
    var PersonalBookInfoCreationPage = require('../pages/PersonalBookInfoCreationPage');
    var loginPage = require('../pages/LoginPage');

    function initializeData() {
        return dataSetService.initialise('user.can.create.personal.book.info').then(function (body) {
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

    it('creates personalBookInfo not in collection correct', function () {
        loginPage.login();

        bookDetailsPage
            .navigateTo(data.bookId);

        personalBookInfoDetails
            .clickOnCreatePersonalBookInfo();

        PersonalBookInfoCreationPage
            .assertOnPage(data.bookId)
            .assertNotInCollectionPanelVisible(false)
            .toggleInCollection()
            .assertNotInCollectionPanelVisible(true)
            .setSold()
            .save();

        bookDetailsPage
            .assertOnPage(data.bookId);

        personalBookInfoDetails
            .assertReasonNotInCollection('Verkocht')
            .assertInCollection(false);
    });

    it('edits personalBookInfo with buyInfo correct', function () {
        var buyPriceAmount = 45;
        var buyReason= 'reason';
        var buyCity= 'city';
        var buyShop = 'shop';
        var buyCountry= 'country';
        var buyDate = '12-12-2000';

        loginPage.login();

        bookDetailsPage
            .navigateTo(data.bookId);

        personalBookInfoDetails
            .clickOnEditPersonalBookInfo();

        PersonalBookInfoCreationPage
            .assertOnEditPage(data.bookId)
            .toggleInCollection()
            .assertInCollectionPanelVisible(true)
            .clickOnBuyInfo()
            .assertBuyInfoPanelVisible(true)
            .setBuyDate(buyDate)
            .setBuyPrice(1, buyPriceAmount)
            .setBuyReason(buyReason)
            .setBuyCity(buyCity)
            .setBuyCountry(buyCountry)
            .setBuyShop(buyShop)
            .save();

        bookDetailsPage
            .assertOnPage(data.bookId);

        personalBookInfoDetails
            .assertBuyDate(buyDate)
            .assertBuyPrice('€', buyPriceAmount)
            .assertBuyCountry(buyCountry)
            .assertBuyCity(buyCity)
            .assertBuyShop(buyShop)
            .assertBuyReason(buyReason);
    });

    it('edits personalBookInfo with giftInfo correct', function () {
        var giftReason= 'reason';
        var giftDate= '12-12-2000';
        var giftOccasion= 'occasion';
        var giftFrom= 'from';

        loginPage.login();

        bookDetailsPage
            .navigateTo(data.bookId);

        personalBookInfoDetails
            .clickOnEditPersonalBookInfo();

        PersonalBookInfoCreationPage
            .assertOnEditPage(data.bookId)
            .assertInCollectionPanelVisible(true)
            .clickOnGiftInfo()
            .assertGiftInfoPanelVisible(true)
            .setGiftDate(giftDate)
            .setGiftReason(giftReason)
            .setGiftOccasion(giftOccasion)
            .setGiftFrom(giftFrom)
            .save();

        bookDetailsPage
            .assertOnPage(data.bookId);

        personalBookInfoDetails
            .assertGiftDate(giftDate)
            .assertGiftOccasion(giftOccasion)
            .assertGiftFrom(giftFrom)
            .assertGiftReason(giftReason);
    });

    it('creates personalBookInfo with buyInfo correct', function () {
        var buyPriceAmount = 45;
        var buyReason= 'reason';
        var buyCity= 'city';
        var buyShop = 'shop';
        var buyCountry= 'country';
        var buyDate = '12-12-2000';

        loginPage.login();

        bookDetailsPage
            .navigateTo(data.secondBookId);

        personalBookInfoDetails
            .clickOnCreatePersonalBookInfo();

        PersonalBookInfoCreationPage
            .assertOnPage(data.secondBookId)
            .assertInCollectionPanelVisible(true)
            .clickOnBuyInfo()
            .assertBuyInfoPanelVisible(true)
            .setBuyDate(buyDate)
            .setBuyPrice(1, buyPriceAmount)
            .setBuyReason(buyReason)
            .setBuyCity(buyCity)
            .setBuyCountry(buyCountry)
            .setBuyShop(buyShop)
            .save();

        bookDetailsPage
            .assertOnPage(data.secondBookId);

        personalBookInfoDetails
            .assertBuyDate(buyDate)
            .assertBuyPrice('€', buyPriceAmount)
            .assertBuyCountry(buyCountry)
            .assertBuyCity(buyCity)
            .assertBuyShop(buyShop)
            .assertBuyReason(buyReason);
    });

    it('creates personalBookInfo with giftInfo correct', function () {
        var giftReason= 'reason';
        var giftDate= '12-12-2000';
        var giftOccasion= 'occasion';
        var giftFrom= 'from';

        loginPage.login();

        bookDetailsPage
            .navigateTo(data.thirdBookId);

        personalBookInfoDetails
            .clickOnCreatePersonalBookInfo();

        PersonalBookInfoCreationPage
            .assertOnPage(data.thirdBookId)
            .assertInCollectionPanelVisible(true)
            .clickOnGiftInfo()
            .assertGiftInfoPanelVisible(true)
            .setGiftDate(giftDate)
            .setGiftReason(giftReason)
            .setGiftOccasion(giftOccasion)
            .setGiftFrom(giftFrom)
            .save();

        bookDetailsPage
            .assertOnPage(data.thirdBookId);

        personalBookInfoDetails
            .assertGiftDate(giftDate)
            .assertGiftOccasion(giftOccasion)
            .assertGiftFrom(giftFrom)
            .assertGiftReason(giftReason);
    });
});
