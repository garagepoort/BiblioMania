<?php

class BookInfoTabPage extends Page{

    function __construct(WebDriver $driver)
    {
        parent::__construct($driver);
    }

    public function getBookTitleElement(){
        return $this->driver->findElement(WebDriverBy::id('book_title_input'));
    }

    public function getBookSubTitleElement(){
        return $this->driver->findElement(WebDriverBy::id('book_subtitle_input'));
    }

    public function getBookAuthorElement(){
        return $this->driver->findElement(WebDriverBy::id('book_author_input'));
    }

    public function getBookISBNElement(){
        return $this->driver->findElement(WebDriverBy::id('book_isbn_input'));
    }

    public function getBookPublisherElement(){
        return $this->driver->findElement(WebDriverBy::id('book_publisher_input'));
    }

    public function getBookPublicationDayElement(){
        return $this->driver->findElement(WebDriverBy::id('book_publication_date_day'));
    }

    public function getBookPublicationMonthElement(){
        return $this->driver->findElement(WebDriverBy::id('book_publication_date_month'));
    }

    public function getBookPublicationYearElement(){
        return $this->driver->findElement(WebDriverBy::id('book_publication_date_year'));
    }

    public function getBookCountryElement(){
        return $this->driver->findElement(WebDriverBy::id('book_country'));
    }

    public function getGenresHeaderElement(){
        return $this->driver->findElement(WebDriverBy::xpath("//div[@id='genres-header']"));
    }

    public function selectGenre($genre){
        $this->driver->findElement(WebDriverBy::xpath("//div[@id='genres-header']"))->click();
        $this->driver->manage()->timeouts()->implicitlyWait(3000);
        $this->driver->findElement(WebDriverBy::xpath("//li[@name='" . $genre . "']"))->click();
        $this->driver->findElement(WebDriverBy::xpath("//div[@id='genres-header']"))->click();
    }

}