<?php

class DeleteReadingDateFromJsonAdapter implements DeleteReadingDateRequest
{

    /** @var  int */
    private $readingDateId;

    /**
     * @return int
     */
    public function getReadingDateId()
    {
        return $this->readingDateId;
    }

    /**
     * @param int $readingDateId
     */
    public function setReadingDateId($readingDateId)
    {
        $this->readingDateId = $readingDateId;
    }


}