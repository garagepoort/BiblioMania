<?php

class CreateBookPageTest extends AbstractUITestCase
{ 
    public function testCreateBook_createsBookCorrect_andRedirectsToBook(){
        $this->login("testUserTests@bendani.com", "xxx");
        $this->driver->get('http://localhost:8888/BiblioMania/createBook');

        $title = 'testTitle';
        $subtitle = 'testSubTitle';
        $author = 'author, authorson';
        $isbn = '1234567890123';
        $number_of_pages = '12';
        $print = '100';
        $publisherName = 'publisher_test';
        $publication_date = '16/12/2014';
        $author_date_of_birth = '16/12/2011';
        $author_date_of_death = '16/12/2018';

        $bookSerieInput = "boekenreeks";
        $publisherSerieInput = "uitgeverreeks";

        $first_print_title = "title";
        $first_print_subtitle = 'sub first print';
        $first_print_isbn = '1234567892345';
        $first_print_publisher = 'first print publisher';
        $first_print_publication_date = '16/12/2000';

        //BOOK INFO
        $this->findElementById('book_title_input')->sendKeys($title);
        $this->findElementById('book_subtitle_input')->sendKeys($subtitle);
        $this->findElementById('book_author_input')->sendKeys($author);
        $this->findElementById('book_isbn_input')->sendKeys($isbn);
        $this->findElementById('book_publisher_input')->sendKeys($publisherName);
        $this->findElementById('book_publication_date_input')->sendKeys($publication_date);
        $this->driver->findElement(WebDriverBy::xpath("//div[@id='genres-header']"))->click();
        $this->driver->manage()->timeouts()->implicitlyWait(3000);
        $this->driver->findElement(WebDriverBy::xpath("//li[@name='YA']"))->click();
        // EXTRA INFO
        $this->findElementById('extra-info-tab-link')->click();
        $this->findElementById('book_number_of_pages_input')->sendKeys($number_of_pages);
        $this->findElementById('book_print_input')->sendKeys($print);
        $this->findElementById('book_serie_input')->sendKeys($bookSerieInput);
        $this->findElementById('publisher_serie_input')->sendKeys($publisherSerieInput);
        // AUTHOR
        $this->findElementById('author-info-tab-link')->click();
        $this->findElementById('author_date_of_birth')->sendKeys($author_date_of_birth);
        $this->findElementById('author_date_of_death')->sendKeys($author_date_of_death);
        // FIRSTPRINT
        $this->findElementById('first-print-info-tab-link')->click();
        $this->findElementById('first_print_title')->sendKeys($first_print_title);
        $this->findElementById('first_print_subtitle')->sendKeys($first_print_subtitle);
        $this->findElementById('first_print_isbn')->sendKeys($first_print_isbn);
        $this->findElementById('first_print_publisher')->sendKeys($first_print_publisher);
        $this->findElementById('first_print_publication_date')->sendKeys($first_print_publication_date);
        // SUBMIT
        $this->findElementById('bookSubmitButton')->click();    


        $book = Book::where('ISBN', '=', '1234567890123')->first();

        $this->driver->manage()->timeouts()->implicitlyWait(3000);

        $this->assertEquals($isbn, $book->ISBN);
        $this->assertEquals($title, $book->title);
        $this->assertEquals($subtitle, $book->subtitle);
        $this->assertEquals($number_of_pages, $book->number_of_pages);
        $this->assertEquals($print, $book->print);
        $this->assertEquals("2014-12-16", $book->publication_date);

        //AUTHOR
        $author = Author::find($book->author_id);
        $this->assertEquals($author->name, 'author');
        $this->assertEquals($author->firstname, 'authorson');
        $this->assertEquals($author->date_of_birth, '2011-12-16');
        $this->assertEquals($author->date_of_death, '2018-12-16');

        //FIRST PRINT INFO
        $firstPrintInfo = FirstPrintInfo::find($book->first_print_info_id);
        $this->assertEquals($firstPrintInfo->title, $first_print_title);
        $this->assertEquals($firstPrintInfo->subtitle, $first_print_subtitle);
        $this->assertEquals($firstPrintInfo->ISBN, $first_print_isbn);
        $this->assertEquals($firstPrintInfo->publication_date, '2000-12-16');
        $firstPrintPub = Publisher::find($firstPrintInfo->publisher_id);
        $this->assertEquals($firstPrintPub->name, $first_print_publisher);

        // PUBLISHER
        $publisher = Publisher::find($book->publisher_id);
        $this->assertEquals($publisher->name, $publisherName);

        // PUBLISHERSERIE
        $publisherSerie = PublisherSerie::find($book->publisher_serie_id);
        $this->assertEquals($publisherSerie->name, $publisherSerieInput);
        
        // BOOKSERIE
        $bookSerie = Serie::find($book->serie_id);
        $this->assertEquals($bookSerie->name, $bookSerieInput);

        $this->assertAtPage('Boeken');
    }

}
?>