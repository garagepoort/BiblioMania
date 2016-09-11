<?php


class CreateFirstPrintInfoRequestTestImpl extends BaseFirstPrintInfoRequestTestImpl implements CreateFirstPrintInfoRequest
{

    private $bookIdToLink = 321;

    /**
     * @return mixed
     */
    public function getBookIdToLink()
    {
        return $this->bookIdToLink;
    }

    /**
     * @param mixed $bookIdToLink
     */
    public function setBookIdToLink($bookIdToLink)
    {
        $this->bookIdToLink = $bookIdToLink;
    }


}