<?php

class PersonalBookInfoTest extends CreateBookPageTest {

    public function testFillInPersonalBookInfo_getsFilledInCorrectly(){
        $this->goToCreateBookPage();
        $this->goToBookInfo();
        $this->fillInFullBook();
        $this->setBookISBN('1234543212345');

        $this->goToPersonalInfo();

        $this->personalBookInfoTabPage->setRating(4);
        $this->personalBookInfoTabPage->getInCollectionElement()->click();
        $this->submitForm();

        $book = Book::where('ISBN', '=', '1234543212345')->with('publisher_serie', 'serie')->first();
        $personalInfo = PersonalBookInfo::where('book_id', '=', $book->id)->first();

        $this->assertEquals(true, $personalInfo->get_owned());
        $this->assertEquals(4, $personalInfo->rating);
    }

    public function testFillInPersonalBookInfo_readingDatesGetFilledInCorrect(){
        $this->goToCreateBookPage();
        $this->goToBookInfo();
        $this->fillInFullBook();
        $this->setBookISBN('1234543212346');

        $this->goToPersonalInfo();
        $this->setValueOfElement($this->personalBookInfoTabPage->getReadingDateInputElement(0), '01/04/2015');
        $this->personalBookInfoTabPage->addDateInput();
        $this->setValueOfElement($this->personalBookInfoTabPage->getReadingDateInputElement(1), '02/05/2016');

        $this->submitForm();

        $book = Book::where('ISBN', '=', '1234543212346')->with('publisher_serie', 'serie')->first();
        $personalInfo = PersonalBookInfo::where('book_id', '=', $book->id)->first();

        $this->assertEquals(2, $personalInfo->reading_dates->count());
        $datetime = DateTime::createFromFormat('Y-m-d', $personalInfo->reading_dates[0]->date);
        $this->assertEquals(1, $datetime->format('d'));
        $this->assertEquals(4, $datetime->format('m'));
        $this->assertEquals(2015, $datetime->format('Y'));
    }

    public function testFillInPersonalBookInfo_whenNotOwned_getsFilledInCorrectly(){
        $this->goToCreateBookPage();
        $this->goToBookInfo();
        $this->fillInFullBook();

        $this->goToPersonalInfo();

        $this->personalBookInfoTabPage->setRating(4);
        $this->submitForm();

        $book = Book::where('ISBN', '=', '1234567890123')->with('publisher_serie', 'serie')->first();
        $personalInfo = PersonalBookInfo::where('book_id', '=', $book->id)->first();

        $this->assertEquals(false, $personalInfo->get_owned());
        $this->assertEquals(4, $personalInfo->rating);
        $this->assertEquals('BORROWED', $personalInfo->reason_not_owned);
    }
}