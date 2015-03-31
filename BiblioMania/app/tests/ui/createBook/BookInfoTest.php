<?php

class BookInfoTest extends CreateBookPageTest{

    public function testFillInBookInfo_getsFilledInCorrectly(){
        $this->goToCreateBookPage();
        $this->bookInfoTabPage->goToBookInfo();
        $this->fillInFullBook();

        $this->bookInfoTabPage->goToBookInfo();
        $this->setValueOfElement($this->bookInfoTabPage->getBookISBNElement(), "1111112222333");
        $this->setValueOfElement($this->bookInfoTabPage->getBookTitleElement(), "title");
        $this->setValueOfElement($this->bookInfoTabPage->getBookSubTitleElement(), "subtitle");
        $this->setValueOfElement($this->bookInfoTabPage->getBookAuthorElement(), "author, authos");
        $this->setValueOfElement($this->bookInfoTabPage->getBookPublisherElement(), "publisherName");
        $this->setValueOfElement($this->bookInfoTabPage->getBookPublicationDayElement(), 16);
        $this->setValueOfElement($this->bookInfoTabPage->getBookPublicationMonthElement(), 12);
        $this->setValueOfElement($this->bookInfoTabPage->getBookPublicationYearElement(), 2014);
        $this->setValueOfElement($this->bookInfoTabPage->getBookCountryElement(), "someCountry");
        $this->bookInfoTabPage->selectGenre('YA');
        $this->bookInfoTabPage->submitForm();

        $book = Book::where('ISBN', '=', '1111112222333')->first();

        $this->driver->manage()->timeouts()->implicitlyWait(3000);

        $this->assertEquals("1111112222333", $book->ISBN);
        $this->assertEquals("title", $book->title);
        $this->assertEquals("subtitle", $book->subtitle);
        $this->assertEquals("author", $book->preferredAuthor()->name);
        $this->assertEquals("authos", $book->preferredAuthor()->firstname);

        $this->assertEquals("publisherName", $book->publisher->name);
        $this->assertEquals(16, $book->publication_date->day);
        $this->assertEquals(12, $book->publication_date->month);
        $this->assertEquals(2014, $book->publication_date->year);
        $this->assertEquals("someCountry", $book->country->name);
    }

}