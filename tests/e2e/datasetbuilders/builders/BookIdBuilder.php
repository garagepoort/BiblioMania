<?php

namespace e2e\datasetbuilders\builders;


use BookIdRequest;

class BookIdBuilder implements BookIdRequest
{

    private $bookId;

    function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param $bookId
     * @return $this
     */
    public function withBookId($bookId)
    {
        $this->bookId = $bookId;
        return $this;
    }

    /**
     * @return BookIdBuilder
     */
    public static function aBookIdRequest(){
        return new BookIdBuilder();
    }


}