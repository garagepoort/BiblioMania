<?php

class CreateBookPageTest extends AbstractUITestCase
{ 
    public $title = 'testTitle';
    public $subtitle = 'testSubTitle';
    public $author = 'author, authorson';
    public $isbn = '1234567890123';
    public $number_of_pages = '12';
    public $print = '100';
    public $publisherName = 'publisher_test';
    public $publication_date = '16/12/2014';
    public $author_date_of_birth = '16/12/2011';
    public $author_date_of_death = '16/12/2018';

    public $bookSerieInput = "boekenreeks";
    public $publisherSerieInput = "uitgeverreeks";

    public $first_print_title = "title";
    public $first_print_subtitle = 'sub first print';
    public $first_print_isbn = '1234567892345';
    public $first_print_publisher = 'first print publisher';
    public $first_print_publication_date = '16/12/2000';

    public $buy_info_buy_date = "15/12/2004";
    public $book_info_retail_price = 500;
    public $buy_info_price_payed = 200;
    public $buy_info_recommended_by = 'gerry';
    public $buy_info_shop = 'shop';
    public $buy_info_city = 'city';


    public function testCreateBook_createsBookCorrect_andRedirectsToBook(){
        $this->login("testUserTests@bendani.com", "xxx");
        $this->driver->get('http://localhost:8888/BiblioMania/createBook');

        //BOOK INFO
        $this->fillInBookInfo();
        // EXTRA INFO
        $this->fillInExtraInfo();
        // AUTHOR
        $this->findElementById('author-info-tab-link')->click();
        $this->findElementById('author_date_of_birth')->sendKeys($this->author_date_of_birth);
        $this->findElementById('author_date_of_death')->sendKeys($this->author_date_of_death);
        // FIRSTPRINT
        $this->findElementById('first-print-info-tab-link')->click();
        $this->findElementById('first_print_title')->sendKeys($this->first_print_title);
        $this->findElementById('first_print_subtitle')->sendKeys($this->first_print_subtitle);
        $this->findElementById('first_print_isbn')->sendKeys($this->first_print_isbn);
        $this->findElementById('first_print_publisher')->sendKeys($this->first_print_publisher);
        $this->findElementById('first_print_publication_date')->sendKeys($this->first_print_publication_date);
        // PERSONAL INFO
        $this->findElementById('personal-info-tab-link')->click();
        $this->findElementById('personal-info-owned-checkbox')->click();
        $this->driver->findElement(WebDriverBy::xpath("//div[@id='star']/img[5]"))->click();
        // BUY INFO
        $this->findElementById('buy-info-tab-link')->click();
        $this->findElementById('buy_info_buy_date')->sendKeys($this->buy_info_buy_date);
        $this->findElementById('buy_book_info_retail_price')->sendKeys($this->book_info_retail_price);
        $this->findElementById('buy_info_price_payed')->sendKeys($this->buy_info_price_payed);
        $this->findElementById('buy_info_recommended_by')->sendKeys($this->buy_info_recommended_by);
        $this->findElementById('buy_info_shop')->sendKeys($this->buy_info_shop);
        $this->findElementById('buy_info_city')->sendKeys($this->buy_info_city);
        
        // SUBMIT
        $this->findElementById('bookSubmitButton')->click();    


        $book = Book::where('ISBN', '=', '1234567890123')->first();

        $this->driver->manage()->timeouts()->implicitlyWait(3000);

        $this->assertEquals($this->isbn, $book->ISBN);
        $this->assertEquals($this->title, $book->title);
        $this->assertEquals($this->subtitle, $book->subtitle);
        $this->assertEquals($this->number_of_pages, $book->number_of_pages);
        $this->assertEquals($this->print, $book->print);
        $publication_date = Date::find($book->publication_date_id);
        $this->assertEquals(16, $publication_date->day);
        $this->assertEquals(12, $publication_date->month);
        $this->assertEquals(2014, $publication_date->year);
        $this->assertEquals($this->book_info_retail_price, $book->retail_price);

        //AUTHOR
        $author = Author::find($book->authors[0]->id);
        $this->assertEquals($author->name, 'author');
        $this->assertEquals($author->firstname, 'authorson');
        $this->assertEquals($author->date_of_birth, '2011-12-16');
        $this->assertEquals($author->date_of_death, '2018-12-16');

        //FIRST PRINT INFO
        $firstPrintInfo = FirstPrintInfo::find($book->first_print_info_id);
        $publication_date = Date::find($firstPrintInfo->publication_date_id);

        $this->assertEquals($firstPrintInfo->title, $this->first_print_title);
        $this->assertEquals($firstPrintInfo->subtitle, $this->first_print_subtitle);
        $this->assertEquals($firstPrintInfo->ISBN, $this->first_print_isbn);
        $this->assertEquals($publication_date->day , 16);
        $this->assertEquals($publication_date->month, 12);
        $this->assertEquals($publication_date->year, 2000);
        $firstPrintPub = Publisher::find($firstPrintInfo->publisher_id);
        $this->assertEquals($firstPrintPub->name, $this->first_print_publisher);


        // PUBLISHER
        $publisher = Publisher::find($book->publisher_id);
        $this->assertEquals($publisher->name, $this->publisherName);

        // PUBLISHERSERIE
        $publisherSerie = PublisherSerie::find($book->publisher_serie_id);
        $this->assertEquals($publisherSerie->name, $this->publisherSerieInput);
        
        // BOOKSERIE
        $bookSerie = Serie::find($book->serie_id);
        $this->assertEquals($bookSerie->name, $this->bookSerieInput);

        // PERSONAL INFO        
        $personalInfo = PersonalBookInfo::where('book_id', '=', $book->id)->first();
        $this->assertEquals(false, $personalInfo->get_owned());
        $this->assertEquals(5, $personalInfo->rating);
        $this->assertEquals('BORROWED', $personalInfo->reason_not_owned);

         //BUY INFO
        $buyInfo = BuyInfo::where('personal_book_info_id', '=', $personalInfo->id)->first();
        $this->assertEquals($buyInfo->buy_date, "2004-12-15");
        $this->assertEquals($buyInfo->price_payed, $this->buy_info_price_payed);
        $this->assertEquals($buyInfo->recommended_by, $this->buy_info_recommended_by);
        $this->assertEquals($buyInfo->shop, $this->buy_info_shop);
        $this->assertEquals($buyInfo->city->name, $this->buy_info_city);

        $this->assertAtPage('Boeken');
    }

    private function fillInBookInfo(){
        $this->findElementById('book_title_input')->sendKeys($this->title);
        $this->findElementById('book_subtitle_input')->sendKeys($this->subtitle);
        $this->findElementById('book_author_input')->sendKeys($this->author);
        $this->findElementById('book_isbn_input')->sendKeys($this->isbn);
        $this->findElementById('book_publisher_input')->sendKeys($this->publisherName);
        $this->findElementById('book_publication_date_input')->sendKeys($this->publication_date);
        $this->driver->findElement(WebDriverBy::xpath("//div[@id='genres-header']"))->click();
        $this->driver->manage()->timeouts()->implicitlyWait(3000);
        $this->driver->findElement(WebDriverBy::xpath("//li[@name='YA']"))->click();
    }

    private function fillInExtraInfo(){
        $this->findElementById('extra-info-tab-link')->click();
        $this->findElementById('book_number_of_pages_input')->sendKeys($this->number_of_pages);
        $this->findElementById('book_print_input')->sendKeys($this->print);
        $this->findElementById('book_serie_input')->sendKeys($this->bookSerieInput);
        $this->findElementById('publisher_serie_input')->sendKeys($this->publisherSerieInput);
    }
}
?>