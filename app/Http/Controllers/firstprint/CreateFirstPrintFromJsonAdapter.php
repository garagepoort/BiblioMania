<?php

class CreateFirstPrintFromJsonAdapter extends BaseFirstPrintFromJsonAdapter implements CreateFirstPrintInfoRequest
{

    /** @var int */
    private $bookIdToLink;

    /**
     * @return int
     */
    public function getBookIdToLink()
    {
        return $this->bookIdToLink;
    }

    /**
     * @param int $bookIdToLink
     */
    public function setBookIdToLink($bookIdToLink)
    {
        $this->bookIdToLink = $bookIdToLink;
    }

}