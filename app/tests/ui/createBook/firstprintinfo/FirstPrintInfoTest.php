<?php

class FirstPrintInfoTest extends CreateBookPageTest{

    public function testFillInAuthorInfo_getsFilledInCorrectly()
    {
        $this->goToCreateBookPage();
        $this->goToBookInfo();
        $this->fillInFullBook();

        $this->goToFirstPrintInfo();

        $this->setValueOfElement($this->firstPrintInfoTabPage->getTitleElement(), 'first title');
        $this->setValueOfElement($this->firstPrintInfoTabPage->getSubTitleElement(), 'first subtitle');
        $this->setValueOfElement($this->firstPrintInfoTabPage->getIsbnElement(), '1293823982931');
        $this->setValueOfElement($this->firstPrintInfoTabPage->getCountryElement(), 'first country');
        $this->setValueOfElement($this->firstPrintInfoTabPage->getPublicationDateDayElement(), '6');
        $this->setValueOfElement($this->firstPrintInfoTabPage->getPublicationDateMonthElement(), '2');
        $this->setValueOfElement($this->firstPrintInfoTabPage->getPublicationDateYearElement(), '1991');
        $this->setValueOfElement($this->firstPrintInfoTabPage->getPublisherElement(), 'first publisher');
        $this->firstPrintInfoTabPage->selectLanguage(2);
        $this->submitForm();

        $book = Book::where('ISBN', '=', '1234567890123')->with('publisher_serie', 'serie')->first();

        $firstPrintInfo = FirstPrintInfo::find($book->first_print_info_id);

        $this->assertEquals($firstPrintInfo->title, 'first title');
        $this->assertEquals($firstPrintInfo->subtitle, 'first subtitle');
        $this->assertEquals($firstPrintInfo->ISBN, '1293823982931');
        $this->assertEquals($firstPrintInfo->country->name, 'first country');
        $this->assertEquals($firstPrintInfo->publication_date->day , 6);
        $this->assertEquals($firstPrintInfo->publication_date->month, 2);
        $this->assertEquals($firstPrintInfo->publication_date->year, 1991);
        $this->assertEquals($firstPrintInfo->publisher->name, 'first publisher');
    }

}