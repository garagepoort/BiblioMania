<?php

class CreateBookPageTest extends AbstractUITestCase
{

    /** @var BookRepository */
    protected $bookRepository;
    /** @var BookInfoTabPage $bookInfoTabPage */
    protected $bookInfoTabPage;
    /** @var AuthorInfoTabPage */
    protected $authorInfoTabPage;
    /** @var ExtraInfoTabPage */
    protected $extraInfoTabPage;
    /** @var FirstPrintInfoTabPage */
    protected $firstPrintInfoTabPage;
    /** @var PersonalBookInfoTabPage */
    protected $personalBookInfoTabPage;

    public $title = 'testTitle';
    public $subtitle = 'testSubTitle';
    public $author = 'author, authorson';
    public $isbn = '1234567890123';
    public $number_of_pages = '12';
    public $print = '100';
    public $publisherName = 'publisher_test';
    public $publisherCountry = 'publisherCountry';
    public $publication_date_day = '16';
    public $publication_date_month = '12';
    public $publication_date_year = '2014';
    public $author_date_of_birth = '16/12/2011';
    public $author_date_of_death = '16/12/2018';

    public $bookSerieInput = "boekenreeks";
    public $publisherSerieInput = "uitgeverreeks";

    public $first_print_title = "title";
    public $first_print_subtitle = 'sub first print';
    public $first_print_isbn = '1234567892345';
    public $first_print_publisher = 'first print publisher';
    public $first_print_publication_date_day = '16';
    public $first_print_publication_date_month = '12';
    public $first_print_publication_date_year = '2000';
    public $first_print_country = 'FirstPrintCountry';

    public $buy_info_buy_date = "15/12/2004";
    public $book_info_retail_price = 500;
    public $buy_info_price_payed = 200;
    public $buy_info_reason = 'gerry';
    public $buy_info_shop = 'shop';
    public $buy_info_city = 'city';
    public $buy_info_country = 'country';

    public function setUp(){
        parent::setUp();
        $this->bookInfoTabPage = new BookInfoTabPage($this->driver);
        $this->authorInfoTabPage = new AuthorInfoTabPage($this->driver);
        $this->extraInfoTabPage = new ExtraInfoTabPage($this->driver);
        $this->firstPrintInfoTabPage = new FirstPrintInfoTabPage($this->driver);
        $this->personalBookInfoTabPage = new PersonalBookInfoTabPage($this->driver);
        $this->bookRepository = App::make('BookRepository');
    }

//    public function testCreateBook_createsBookCorrect_andRedirectsToBook(){
//        $this->goToCreateBookPage();
//
//        $this->fillInBookInfo();
//        $this->fillInExtraInfo();
//        $this->fillInAuthorInfo();
//        $this->fillInFirstPrintInfo();
//        $this->fillInPersonalInfo();
//        $this->fillInBuyInfo();
//        // SUBMIT
//        $this->submitForm();
//
//
//        $book = Book::where('ISBN', '=', '1234567890123')->first();
//
//        $this->driver->manage()->timeouts()->implicitlyWait(3000);
//
//        $this->assertEquals($this->isbn, $book->ISBN);
//        $this->assertEquals($this->title, $book->title);
//        $this->assertEquals($this->subtitle, $book->subtitle);
//        $this->assertEquals($this->number_of_pages, $book->number_of_pages);
//        $this->assertEquals($this->print, $book->print);
//        $publication_date = Date::find($book->publication_date_id);
//        $this->assertEquals(16, $this->publication_date_day);
//        $this->assertEquals(12, $this->publication_date_month);
//        $this->assertEquals(2014, $this->publication_date_year);
//        $this->assertEquals($this->book_info_retail_price, $book->retail_price);
//
//        //AUTHOR
//        $author = Author::find($book->authors[0]->id);
//        $this->assertEquals($author->name, 'author');
//        $this->assertEquals($author->firstname, 'authorson');
//        $this->assertEquals($author->date_of_birth->day, '13');
//        $this->assertEquals($author->date_of_birth->month, '12');
//        $this->assertEquals($author->date_of_birth->year, '2013');
//        $this->assertEquals($author->date_of_death->day, '14');
//        $this->assertEquals($author->date_of_death->month, '11');
//        $this->assertEquals($author->date_of_death->year, '2014');
//
//        //FIRST PRINT INFO
//        $firstPrintInfo = FirstPrintInfo::find($book->first_print_info_id);
//        $publication_date = Date::find($firstPrintInfo->publication_date_id);
//
//        $this->assertEquals($firstPrintInfo->title, $this->first_print_title);
//        $this->assertEquals($firstPrintInfo->subtitle, $this->first_print_subtitle);
//        $this->assertEquals($firstPrintInfo->ISBN, $this->first_print_isbn);
//        $this->assertEquals($firstPrintInfo->country->name, $this->first_print_country);
//        $this->assertEquals($publication_date->day , $this->first_print_publication_date_day);
//        $this->assertEquals($publication_date->month, $this->first_print_publication_date_month);
//        $this->assertEquals($publication_date->year, $this->first_print_publication_date_year);
//        $firstPrintPub = Publisher::find($firstPrintInfo->publisher_id);
//        $this->assertEquals($firstPrintPub->name, $this->first_print_publisher);
//
//        // PUBLISHER
//        $publisher = Publisher::find($book->publisher_id);
//        $this->assertEquals($publisher->name, $this->publisherName);
//        $this->assertEquals($publisher->countries[0]->name, $this->publisherCountry);
//
//        // PUBLISHERSERIE
//        $publisherSerie = PublisherSerie::find($book->publisher_serie_id);
//        $this->assertEquals($publisherSerie->name, $this->publisherSerieInput);
//
//        // BOOKSERIE
//        $bookSerie = Serie::find($book->serie_id);
//        $this->assertEquals($bookSerie->name, $this->bookSerieInput);
//
//        // PERSONAL INFO
//        $personalInfo = PersonalBookInfo::where('book_id', '=', $book->id)->first();
//        $this->assertEquals(false, $personalInfo->get_owned());
//        $this->assertEquals(5, $personalInfo->rating);
//        $this->assertEquals('BORROWED', $personalInfo->reason_not_owned);
//
//         //BUY INFO
//        $buyInfo = BuyInfo::where('personal_book_info_id', '=', $personalInfo->id)->first();
//        $this->assertEquals($buyInfo->buy_date, "2004-12-15");
//        $this->assertEquals($buyInfo->price_payed, $this->buy_info_price_payed);
//        $this->assertEquals($buyInfo->recommended_by, $this->buy_info_recommended_by);
//        $this->assertEquals($buyInfo->shop, $this->buy_info_shop);
//        $this->assertEquals($buyInfo->city->name, $this->buy_info_city);
//        $this->assertEquals($buyInfo->city->country->name, $this->buy_info_country);
//
//        $this->assertAtPage('Boeken');
//    }

    protected function fillInFullBook(){
        $this->fillInBookInfo();
        $this->fillInExtraInfo();
        $this->fillInAuthorInfo();
        $this->fillInFirstPrintInfo();
        $this->fillInPersonalInfo();
        $this->fillInBuyInfo();
    }

    protected function setBookISBN($isbn){
        $this->goToBookInfo();
        $this->setValueOfElement($this->bookInfoTabPage->getBookISBNElement(), $isbn);
    }

    private function fillInBookInfo(){
        $this->setValueOfInputField('book_title_input', $this->title);
        $this->setValueOfInputField('book_subtitle_input', $this->subtitle);
        $this->setValueOfInputField('book_author_input', $this->author);
        $this->setValueOfInputField('book_isbn_input', $this->isbn);
        $this->setValueOfInputField('book_publisher_input', $this->publisherName);
        $this->setValueOfInputField('book_publication_date_day', $this->publication_date_day);
        $this->setValueOfInputField('book_publication_date_month', $this->publication_date_month);
        $this->setValueOfInputField('book_publication_date_year', $this->publication_date_year);
        $this->setValueOfInputField('book_country', $this->publisherCountry);
        $this->bookInfoTabPage->selectGenre('YA');
    }

    private function fillInExtraInfo(){
        $this->goToExtraInfo();
        $this->findElementById('book_number_of_pages_input')->sendKeys($this->number_of_pages);
        $this->findElementById('book_print_input')->sendKeys($this->print);
        $this->findElementById('book_serie_input')->sendKeys($this->bookSerieInput);
        $this->findElementById('publisher_serie_input')->sendKeys($this->publisherSerieInput);
    }

    private function fillInAuthorInfo(){
        $this->goToAuthorInfo();
        $this->findElementById('author_date_of_birth_day')->sendKeys("13");
        $this->findElementById('author_date_of_birth_month')->sendKeys("12");
        $this->findElementById('author_date_of_birth_year')->sendKeys("2013");

        $this->findElementById('author_date_of_death_day')->sendKeys("14");
        $this->findElementById('author_date_of_death_month')->sendKeys("11");
        $this->findElementById('author_date_of_death_year')->sendKeys("2014");
    }

    protected function fillInFirstPrintInfo()
    {
        $this->goToFirstPrintInfo();
        $this->setValueOfInputField('first_print_title', $this->first_print_title);
        $this->setValueOfInputField('first_print_subtitle', $this->first_print_subtitle);
        $this->setValueOfInputField('first_print_isbn', $this->first_print_isbn);
        $this->setValueOfInputField('first_print_publisher', $this->first_print_publisher);
        $this->setValueOfInputField('first_print_publication_date_day', $this->first_print_publication_date_day);
        $this->setValueOfInputField('first_print_publication_date_month', $this->first_print_publication_date_month);
        $this->setValueOfInputField('first_print_publication_date_year', $this->first_print_publication_date_year);
        $this->setValueOfInputField('first_print_country', $this->first_print_country);
    }

    protected function fillInPersonalInfo()
    {
        $this->goToPersonalInfo();
        $this->findElementById('personal-info-owned-checkbox')->click();
        $this->driver->findElement(WebDriverBy::xpath("//div[@id='star']/img[5]"))->click();
    }

    protected function fillInBuyInfo()
    {
        $this->goToBuyInfo();
        $this->findElementById('buy_info_buy_date')->sendKeys($this->buy_info_buy_date);
        $this->findElementById('buy_book_info_retail_price')->sendKeys($this->book_info_retail_price);
        $this->findElementById('buy_info_price_payed')->sendKeys($this->buy_info_price_payed);
        $this->findElementById('buy_info_reason')->sendKeys($this->buy_info_reason);
        $this->findElementById('buy_info_shop')->sendKeys($this->buy_info_shop);
        $this->findElementById('buy_info_city')->sendKeys($this->buy_info_city);
        $this->findElementById('buy_info_country')->sendKeys($this->buy_info_country);
    }

    public function goToCreateBookPage(){
        $this->login("testUserTests@bendani.com", "xxx");
        $this->driver->get('http://localhost:8888/BiblioMania/createBook');
    }


    public function goToFirstPrintInfo()
    {
        return $this->driver->findElement(WebDriverBy::id('first-print-info-tab-link'))->click();
    }

    public function goToAuthorInfo()
    {
        $this->driver->findElement(WebDriverBy::id('author-info-tab-link'))->click();
    }

    public function goToBookInfo()
    {
        $this->driver->findElement(WebDriverBy::id('book-info-tab-link'))->click();
    }

    public function goToBuyInfo()
    {
        $this->driver->findElement(WebDriverBy::id('buy-info-tab-link'))->click();
    }

    public function goToPersonalInfo()
    {
        $this->driver->findElement(WebDriverBy::id('personal-info-tab-link'))->click();
    }

    public function submitForm()
    {
        $this->driver->findElement(WebDriverBy::id('bookSubmitButton'))->click();
    }

    public function goToExtraInfo()
    {
        $this->driver->findElement(WebDriverBy::id('extra-info-tab-link'))->click();
    }
}