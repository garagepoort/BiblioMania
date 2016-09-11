<?php

namespace e2e\datasetbuilders;


use BuyInfoRequest;
use CreatePersonalBookInfoRequest;
use GiftInfoRequest;

class PersonalBookInfoBuilder implements CreatePersonalBookInfoRequest
{

    private $inCollection;
    private $reasonNotInCollection;
    private $bookId;


    function isInCollection()
    {
        return $this->inCollection;
    }

    function getReasonNotInCollection()
    {
        return $this->reasonNotInCollection;
    }

    /**
     * @return BuyInfoRequest
     */
    function getBuyInfo()
    {
        // TODO: Implement getBuyInfo() method.
    }

    /**
     * @return GiftInfoRequest
     */
    function getGiftInfo()
    {
        // TODO: Implement getGiftInfo() method.
    }

    function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param mixed $inCollection
     * @return $this
     */
    public function withInCollection($inCollection)
    {
        $this->inCollection = $inCollection;
        return $this;
    }

    /**
     * @param mixed $reasonNotInCollection
     * @return $this
     */
    public function withReasonNotInCollection($reasonNotInCollection)
    {
        $this->reasonNotInCollection = $reasonNotInCollection;
        return $this;
    }

    /**
     * @param mixed $bookId
     * @return $this
     */
    public function withBookId($bookId)
    {
        $this->bookId = $bookId;
        return $this;
    }

    public static function newPersonalBookInfo(){
        return new PersonalBookInfoBuilder();
    }


}