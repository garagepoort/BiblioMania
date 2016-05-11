describe('create.book.e2e.test', function () {
    var dataSetService = require('../DataSetService');
    var bookCreationPage = require('../pages/BookCreationPage');
    var bookDetailsPage = require('../pages/BookDetailsPage');
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
            .assertPublicationDate(PUBLICATION_DATE)
            .assertPublisher(PUBLISHER)
            .assertGenre(GENRE)
            .assertContainsAuthor(1, data.authorId, AUTHOR_FIRSTNAME, AUTHOR_LASTNAME)
            .assertPrint(PRINT)
            .assertPages(PAGES)
            .assertBookSerie(SERIE)
            .assertPublisherSerie(PUBLISHER_SERIE)
            .assertTranslator(TRANSLATOR)
            .assertRetailPrice('$ ' + RETAIL_PRICE_AMOUNT);
    });

    fit('creates book correctly with newly created author and redirects to book overview page', function () {
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
            .assertPublicationDate(PUBLICATION_DATE)
            .assertPublisher(PUBLISHER)
            .assertGenre(GENRE)
            .assertContainsAuthor(1, 2, "newFirstname", "newLastname")
            .assertPrint(PRINT)
            .assertPages(PAGES)
            .assertBookSerie(SERIE)
            .assertPublisherSerie(PUBLISHER_SERIE)
            .assertTranslator(TRANSLATOR)
            .assertRetailPrice('$ ' + RETAIL_PRICE_AMOUNT);
    });

});
