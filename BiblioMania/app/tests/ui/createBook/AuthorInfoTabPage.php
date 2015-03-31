<?php

class AuthorInfoTabPage extends Page{

    function __construct(WebDriver $driver)
    {
        parent::__construct($driver);
    }

    public function fillInAuthorInfo(){
        $this->findElementById('author_date_of_birth_day')->sendKeys("13");
        $this->findElementById('author_date_of_birth_month')->sendKeys("12");
        $this->findElementById('author_date_of_birth_year')->sendKeys("2013");

        $this->findElementById('author_date_of_death_day')->sendKeys("14");
        $this->findElementById('author_date_of_death_month')->sendKeys("11");
        $this->findElementById('author_date_of_death_year')->sendKeys("2014");
    }

}