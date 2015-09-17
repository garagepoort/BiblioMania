<?php

class FirstPrintInfoTabPage extends Page{

    public function getTitleElement(){
        return $this->findElementById("first_print_title");
    }

    public function getSubTitleElement(){
        return $this->findElementById("first_print_subtitle");
    }

    public function getIsbnElement(){
        return $this->findElementById("first_print_isbn");
    }

    public function getCountryElement(){
        return $this->findElementById("first_print_country");
    }

    public function selectLanguage($index){
        return $this->findSelectById("first_print_info_language")->selectByIndex($index);
    }

    public function getPublisherElement(){
        return $this->findElementById("first_print_publisher");
    }

    public function getPublicationDateDayElement(){
        return $this->findElementById("first_print_publication_date_day");
    }

    public function getPublicationDateMonthElement(){
        return $this->findElementById("first_print_publication_date_month");
    }

    public function getPublicationDateYearElement(){
        return $this->findElementById("first_print_publication_date_year");
    }

}