<?php

class AuthorInfoTest extends CreateBookPageTest
{

    public function testFillInAuthorInfo_getsFilledInCorrectly()
    {
        $this->goToCreateBookPage();
        $this->goToBookInfo();
        $this->fillInFullBook();

        $this->goToAuthorInfo();
        $this->setValueOfElement($this->authorInfoTabPage->getNameElement(), "name");
        $this->setValueOfElement($this->authorInfoTabPage->getFirstNameElement(), "firstname");
        $this->setValueOfElement($this->authorInfoTabPage->getInfixElement(), "infix");
        $this->setValueOfElement($this->authorInfoTabPage->getDateOfBirthDayElement(), "6");
        $this->setValueOfElement($this->authorInfoTabPage->getDateOfBirthMonthElement(), "2");
        $this->setValueOfElement($this->authorInfoTabPage->getAuthorDateOfBirthYearElement(), "1991");
        $this->setValueOfElement($this->authorInfoTabPage->getDateOfDeathDayElement(), "7");
        $this->setValueOfElement($this->authorInfoTabPage->getDateOfDeathMonthElement(), "3");
        $this->setValueOfElement($this->authorInfoTabPage->getDateOfDeathYearElement(), "2031");
        $this->submitForm();

        $book = Book::where('ISBN', '=', '1234567890123')->first();

        $this->driver->manage()->timeouts()->implicitlyWait(3000);

        $author = Author::find($book->authors[0]->id);
        $this->assertEquals($author->name, 'name');
        $this->assertEquals($author->firstname, 'firstname');
        $this->assertEquals($author->infix, 'infix');
        $this->assertEquals($author->date_of_birth->day, '6');
        $this->assertEquals($author->date_of_birth->month, '2');
        $this->assertEquals($author->date_of_birth->year, '1991');
        $this->assertEquals($author->date_of_death->day, '7');
        $this->assertEquals($author->date_of_death->month, '3');
        $this->assertEquals($author->date_of_death->year, '2031');
    }
}