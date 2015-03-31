<?php

class AuthorInfoTest extends CreateBookPageTest{

    public function testFillInAuthorInfo_getsFilledInCorrectly(){
        $this->goToCreateBookPage();
        $this->goToBookInfo();
        $this->fillInFullBook();

        $this->goToAuthorInfo();
        $this->setValueOfElement($this->authorInfoTabPage->get(), "1111112222333");
        $this->setValueOfElement($this->authorInfoTabPage->getBookTitleElement(), "title");
        $this->setValueOfElement($this->authorInfoTabPage->getBookSubTitleElement(), "subtitle");
        $this->setValueOfElement($this->authorInfoTabPage->getBookAuthorElement(), "author, authos");
        $this->setValueOfElement($this->authorInfoTabPage->getBookPublisherElement(), "publisherName");
        $this->setValueOfElement($this->authorInfoTabPage->getBookPublicationDayElement(), 16);
        $this->setValueOfElement($this->authorInfoTabPage->getBookPublicationMonthElement(), 12);
        $this->setValueOfElement($this->authorInfoTabPage->getBookPublicationYearElement(), 2014);
        $this->setValueOfElement($this->authorInfoTabPage->getBookCountryElement(), "someCountry");
        $this->authorInfoTabPage->selectGenre('YA');
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