describe('user.can.create.book', function () {
    var dataSetService = require('../DataSetService');
    var bookCreationPage = require('../pages/BookCreationPage');
    var bookDetailsPage = require('../pages/BookDetailsPage');
    var bookAuthorsDetails = require('../pages/BookAuthorsDetails');
    var loginPage = require('../pages/LoginPage');
    var authorSelectionModalPage = require('../pages/AuthorSelectionModalPage');
    var authorCreationModalPage = require('../pages/AuthorCreationModalPage');

    var datasetInitialized = false;
    var data;

    var TITLE = 'title';
    var SUBTITLE = 'subtitle';
    var ISBN = '1234567890123';
    var SUMMARY = 'summary';
    var PUBLISHER = 'publisher';
    var COUNTRY = 'Frankrijk';
    var GENRE = 'Contemporary';
    var AUTHOR_FIRSTNAME = 'first';
    var AUTHOR_LASTNAME = 'last';
    var PUBLICATION_DATE = '4-3-2000';
    var LANGUAGE = 'Engels';
    var TRANSLATOR = 'translator';
    var PAGES = '100';
    var PRINT = '12';
    var SERIE = "bookSerie";
    var PUBLISHER_SERIE = "publisherSerie";
    var RETAIL_PRICE_AMOUNT = '321';

    function initializeData() {
        return dataSetService.initialise('user.can.create.book').then(function (body) {
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


    it('creates book correctly with selected author and redirects to book overview page', function () {
        loginPage.login();

        bookCreationPage
            .navigateTo()
            .setTitle(TITLE)
            .setSubtitle(SUBTITLE)
            .setIsbn(ISBN)
            .setSummary(SUMMARY)
            .openSelectAuthor();

        authorSelectionModalPage.assertOnModal()
            .selectAuthor(data.authorId)
            .assertNotOnModal();

        bookCreationPage
            .assertAuthorName(AUTHOR_FIRSTNAME, AUTHOR_LASTNAME)
            .setPublisher(PUBLISHER)
            .setPublicationDate(4, 3, 2000)
            .setCountry(COUNTRY)
            .selectLanguage(1)
            .openGenreBranch('YA')
            .selectGenre(GENRE)
            .setPrint(PRINT)
            .setPages(PAGES)
            .setTranslator(TRANSLATOR)
            .setBookSerie(SERIE)
            .setPublisherSerie(PUBLISHER_SERIE)
            .setRetailPrice(1, RETAIL_PRICE_AMOUNT)
            .saveBook();

        bookDetailsPage
            .assertOnPage(1)
            .assertTitle(TITLE)
            .assertSubtitle(SUBTITLE)
            .assertIsbn(ISBN)
            .assertLanguage(LANGUAGE)
            .assertCountry(COUNTRY)
            .assertPublicationDate(PUBLICATION_DATE)
            .assertPublisher(PUBLISHER)
            .assertGenre(GENRE)
            .assertPrint(PRINT)
            .assertPages(PAGES)
            .assertBookSerie(SERIE)
            .assertPublisherSerie(PUBLISHER_SERIE)
            .assertTranslator(TRANSLATOR)
            .assertRetailPrice('$ ' + RETAIL_PRICE_AMOUNT);

        bookAuthorsDetails
            .assertContainsAuthor(1, data.authorId, AUTHOR_FIRSTNAME, AUTHOR_LASTNAME);
    });

    it('creates book correctly with newly created author and redirects to book overview page', function () {
        loginPage.login();

        bookCreationPage
            .navigateTo()
            .setTitle(TITLE)
            .setSubtitle(SUBTITLE)
            .setIsbn(ISBN)
            .setSummary(SUMMARY)
            .openCreateAuthor();

        authorCreationModalPage.assertOnModal()
            .setFirstname('newFirstname')
            .setInfix('newInfix')
            .setLastname('newLastname')
            .clickCreateAuthorButton()
            .assertNotOnModal();

        bookCreationPage
            .assertAuthorName('newFirstname', 'newLastname')
            .setPublisher(PUBLISHER)
            .setPublicationDate(4, 3, 2000)
            .setCountry(COUNTRY)
            .selectLanguage(1)
            .openGenreBranch('YA')
            .selectGenre(GENRE)
            .setPrint(PRINT)
            .setPages(PAGES)
            .setTranslator(TRANSLATOR)
            .setBookSerie(SERIE)
            .setPublisherSerie(PUBLISHER_SERIE)
            .setRetailPrice(1, RETAIL_PRICE_AMOUNT)
            .saveBook();

        bookDetailsPage
            .assertOnPage(2)
            .assertTitle(TITLE)
            .assertSubtitle(SUBTITLE)
            .assertIsbn(ISBN)
            .assertLanguage(LANGUAGE)
            .assertPublicationDate(PUBLICATION_DATE)
            .assertPublisher(PUBLISHER)
            .assertGenre(GENRE)
            .assertPrint(PRINT)
            .assertPages(PAGES)
            .assertBookSerie(SERIE)
            .assertPublisherSerie(PUBLISHER_SERIE)
            .assertTranslator(TRANSLATOR)
            .assertRetailPrice('$ ' + RETAIL_PRICE_AMOUNT);

        bookAuthorsDetails
            .assertContainsAuthor(2, 2, "newFirstname", "newLastname");
    });

});
