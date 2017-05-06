<?php

class CreatePersonalBookInfoFromJsonAdapter extends BasePersonalBookInfoFromJsonAdapter implements CreatePersonalBookInfoRequest
{
    /** @var  int */
    /** @required   */
    private $bookId;

    /**
     * @return mixed
     */
    public function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param mixed $bookId
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
    }

}