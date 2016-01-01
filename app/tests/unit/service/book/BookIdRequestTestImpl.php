<?php

class BookIdRequestTestImpl implements BookIdRequest
{

    private $bookId = 291038;

    function getBookId()
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