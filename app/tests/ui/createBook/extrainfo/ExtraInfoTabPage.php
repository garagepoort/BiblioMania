<?php

class ExtraInfoTabPage extends Page{

    function __construct(WebDriver $driver)
    {
        parent::__construct($driver);
    }

    public function getPagesElement(){
        return $this->findElementById('book_number_of_pages_input');
    }

    public function getPrintElement(){
        return $this->findElementById('book_print_input');
    }

    public function getTranslatorElement(){
        return $this->findElementById('translator_input');
    }

    public function getBookSerieElement(){
        return $this->findElementById('book_serie_input');
    }

    public function getPublisherSerieElement(){
        return $this->findElementById('publisher_serie_input');
    }


}