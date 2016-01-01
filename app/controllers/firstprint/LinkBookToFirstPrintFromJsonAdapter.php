<?php

class LinkBookToFirstPrintFromJsonAdapter implements LinkBookToFirstPrintInfoRequest
{

    /** @var int */
    private $bookId;

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