<?php

class AuthorInfoTabPage extends Page
{

    function __construct(WebDriver $driver)
    {
        parent::__construct($driver);
    }

    public function fillInAuthorInfo()
    {
        $this->findElementById('author_date_of_birth_day')->sendKeys("13");
        $this->findElementById('author_date_of_birth_month')->sendKeys("12");
        $this->findElementById('author_date_of_birth_year')->sendKeys("2013");

        $this->findElementById('author_date_of_death_day')->sendKeys("14");
        $this->findElementById('author_date_of_death_month')->sendKeys("11");
        $this->findElementById('author_date_of_death_year')->sendKeys("2014");
    }

    public function getNameElement()
    {
        return $this->findElementById('author_name');
    }

    public function getFirstNameElement()
    {
        return $this->findElementById('author_firstname');
    }

    public function getInfixElement()
    {
        return $this->findElementById('author_infix');
    }

    public function getDateOfBirthDayElement()
    {
        return $this->findElementById('author_date_of_birth_day');
    }

    public function getDateOfBirthMonthElement()
    {
        return $this->findElementById('author_date_of_birth_month');
    }

    public function getAuthorDateOfBirthYearElement()
    {
        return $this->findElementById('author_date_of_birth_year');
    }

    public function getDateOfDeathDayElement()
    {
        return $this->findElementById('author_date_of_death_day');
    }

    public function getDateOfDeathMonthElement()
    {
        return $this->findElementById('author_date_of_death_month');
    }

    public function getDateOfDeathYearElement()
    {
        return $this->findElementById('author_date_of_death_year');
    }

}