<?php

class BookInfoTest extends CreateBookPageTest{

    public function testFillInBookInfo_getsFilledInCorrectly(){
        $this->goToCreateBookPage();
        $this->goToBookInfo();
        $this->fillInFullBook();

        $this->goToBookInfo();
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
        $this->submitForm();

        $this->driver->manage()->timeouts()->implicitlyWait(3000);

        $book = Book::where('ISBN', '=', '1111112222333')->first();


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


    public function testFillInAuthorOnBookInfo_copiesValueToAuthor(){
        $this->goToCreateBookPage();

        //full name
        $this->goToBookInfo();
        $this->setValueOfInputField('book_author_input', 'author, mid, authorson');
        $this->goToAuthorInfo();
        $this->assertEquals($this->authorInfoTabPage->getNameElement()->getAttribute('value'), 'author');
        $this->assertEquals($this->authorInfoTabPage->getFirstNameElement()->getAttribute('value'), 'authorson');
        $this->assertEquals($this->authorInfoTabPage->getInfixElement()->getAttribute('value'), 'mid');

        //name without infix
        $this->goToBookInfo();
        $this->setValueOfInputField('book_author_input', 'author, authorson');
        $this->goToAuthorInfo();
        $this->assertEquals($this->authorInfoTabPage->getNameElement()->getAttribute('value'), 'author');
        $this->assertEquals($this->authorInfoTabPage->getFirstNameElement()->getAttribute('value'), 'authorson');
        $this->assertEquals($this->authorInfoTabPage->getInfixElement()->getAttribute('value'), '');

        //one name
        $this->goToBookInfo();
        $this->setValueOfInputField('book_author_input', 'author');
        $this->goToAuthorInfo();
        $this->assertEquals($this->authorInfoTabPage->getNameElement()->getAttribute('value'), 'author');
        $this->assertEquals($this->authorInfoTabPage->getFirstNameElement()->getAttribute('value'), '');
        $this->assertEquals($this->authorInfoTabPage->getInfixElement()->getAttribute('value'), '');

        //name with spaces
        $this->goToBookInfo();
        $this->setValueOfInputField('book_author_input', 'author some, mid, authrosons 2nd');
        $this->goToAuthorInfo();
        $this->assertEquals($this->authorInfoTabPage->getNameElement()->getAttribute('value'), 'author some');
        $this->assertEquals($this->authorInfoTabPage->getFirstNameElement()->getAttribute('value'), 'authrosons 2nd');
        $this->assertEquals($this->authorInfoTabPage->getInfixElement()->getAttribute('value'), 'mid');
    }

    public function testFillInAuthorOnAuthorInfo_copiesValueToAuthorOnBookInfo(){
        $this->goToCreateBookPage();

        //full name
        $this->goToAuthorInfo();
        $this->authorInfoTabPage->getNameElement()->clear();
        $this->authorInfoTabPage->getFirstNameElement()->clear();
        $this->authorInfoTabPage->getInfixElement()->clear();

        $this->authorInfoTabPage->getNameElement()->sendKeys("someAuthorName");
        $this->authorInfoTabPage->getFirstNameElement()->sendKeys("someAuthorFirstName");
        $this->authorInfoTabPage->getInfixElement()->sendKeys("mid");
        $this->goToBookInfo();
        $this->assertEquals($this->bookInfoTabPage->getBookAuthorElement()->getAttribute('value'), 'someAuthorName, mid, someAuthorFirstName');

        $this->driver->manage()->timeouts()->implicitlyWait(3000);

        //Partial name
        $this->goToAuthorInfo();
        $this->authorInfoTabPage->getNameElement()->clear();
        $this->authorInfoTabPage->getFirstNameElement()->clear();
        $this->authorInfoTabPage->getInfixElement()->clear();

        $this->authorInfoTabPage->getNameElement()->sendKeys("someAuthorName");
        $this->authorInfoTabPage->getFirstNameElement()->sendKeys("");
        $this->authorInfoTabPage->getInfixElement()->sendKeys("");
        $this->goToBookInfo();
        $this->driver->manage()->timeouts()->implicitlyWait(3000);
        $this->assertEquals($this->bookInfoTabPage->getBookAuthorElement()->getAttribute('value'), 'someAuthorName, ');
    }

}