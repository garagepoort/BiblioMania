<?php

class ExtraBookInfoTest extends CreateBookPageTest{

    public function testFillInExtraInfo_fillsInCorrect(){
        $this->goToCreateBookPage();
        $this->goToBookInfo();
        $this->fillInFullBook();

        $this->goToExtraInfo();
        $this->setValueOfElement($this->extraInfoTabPage->getPagesElement(), "120");
        $this->setValueOfElement($this->extraInfoTabPage->getPrintElement(), "3");
        $this->setValueOfElement($this->extraInfoTabPage->getBookSerieElement(), "bookSerie");
        $this->setValueOfElement($this->extraInfoTabPage->getPublisherSerieElement(), "publisherSerie");
        $this->setValueOfElement($this->extraInfoTabPage->getTranslatorElement(), "translator");
        $this->submitForm();

        $book = Book::where('ISBN', '=', '1234567890123')->with('publisher_serie', 'book_serie')->first();

        $this->driver->manage()->timeouts()->implicitlyWait(3000);
        $this->assertEquals($book->publisher_serie->name, 'publisherSerie');
        $this->assertEquals($book->serie->name, 'bookSerie');
        $this->assertEquals($book->print, '3');
        $this->assertEquals($book->number_of_pages, '120');
        $this->assertEquals($book->translator, 'translator');
    }
}