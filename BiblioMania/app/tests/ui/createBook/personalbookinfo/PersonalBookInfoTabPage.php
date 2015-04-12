<?php

class PersonalBookInfoTabPage extends Page {

    public function setRating($rating){
        $this->driver->findElement(WebDriverBy::xpath("//div[@id='star']/img[" . $rating ."]"))->click();
    }

    public function getInCollectionElement(){
        return $this->findElementById('personal-info-owned-checkbox');
    }

    public function addDateInput(){
        $this->findElementById("reading-date-plus")->click();
    }

    public function removeDateInput(){
        $this->findElementById("reading-date-min")->click();
    }

    public function getReadingDateInputElement($index){
        return $this->findElementById("reading_date_input_" . $index);
    }

}