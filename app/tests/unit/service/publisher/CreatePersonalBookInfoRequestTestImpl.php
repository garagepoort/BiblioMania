<?php

class CreatePersonalBookInfoRequestTestImpl implements CreatePersonalBookInfoRequest
{

    private $inCollection;
    private $reasonNotInCollection;
    /** @var  BuyInfoRequestTestImpl */
    private $buyInfo;
    /** @var  GiftInfoRequestTestImpl */
    private $giftInfo;
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
        return $this->buyInfo;
    }

    /**
     * @return GiftInfoRequest
     */
    function getGiftInfo()
    {
        return $this->giftInfo;
    }

    function getBookId()
    {
        return $this->bookId;
    }

    /**
     * @param mixed $inCollection
     */
    public function setInCollection($inCollection)
    {
        $this->inCollection = $inCollection;
    }

    /**
     * @param mixed $reasonNotInCollection
     */
    public function setReasonNotInCollection($reasonNotInCollection)
    {
        $this->reasonNotInCollection = $reasonNotInCollection;
    }

    /**
     * @param BuyInfoRequestTestImpl $buyInfo
     */
    public function setBuyInfo($buyInfo)
    {
        $this->buyInfo = $buyInfo;
    }

    /**
     * @param GiftInfoRequestTestImpl $giftInfo
     */
    public function setGiftInfo($giftInfo)
    {
        $this->giftInfo = $giftInfo;
    }

    /**
     * @param mixed $bookId
     */
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
    }


}