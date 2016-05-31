<?php

class LinkBookToFirstPrintInfoRequestTestImpl implements LinkBookToFirstPrintInfoRequest
{

    private $bookId = 54321;

    /**
     * @return int
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param int $bookId
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
    }


}