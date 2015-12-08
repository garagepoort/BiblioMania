<?php

class BasePersonalBookInfoFromJsonAdapter implements BasePersonalBookInfoRequest
{
    /** @var  int */
    private $rating = 0;
    /** @var  string */
    private $review;
    /** @var  boolean */
    private $inCollection;
    /** @var  string */
    private $reasonNotInCollection;
    /** @var  BuyInfoFromJsonAdapter */
    private $buyInfo;
    /** @var  GiftInfoFromJsonAdapter */
    private $giftInfo;

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return string
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @param string $review
     */
    public function setReview($review)
    {
        $this->review = $review;
    }

    /**
     * @return boolean
     */
    public function isInCollection()
    {
        return $this->inCollection;
    }

    /**
     * @param boolean $inCollection
     */
    public function setInCollection($inCollection)
    {
        $this->inCollection = $inCollection;
    }

    /**
     * @return string
     */
    public function getReasonNotInCollection()
    {
        return $this->reasonNotInCollection;
    }

    /**
     * @param string $reasonNotInCollection
     */
    public function setReasonNotInCollection($reasonNotInCollection)
    {
        $this->reasonNotInCollection = $reasonNotInCollection;
    }

    /**
     * @return BuyInfoFromJsonAdapter
     */
    public function getBuyInfo()
    {
        return $this->buyInfo;
    }

    /**
     * @param BuyInfoFromJsonAdapter $buyInfo
     */
    public function setBuyInfo($buyInfo)
    {
        $this->buyInfo = $buyInfo;
    }

    /**
     * @return GiftInfoFromJsonAdapter
     */
    public function getGiftInfo()
    {
        return $this->giftInfo;
    }

    /**
     * @param GiftInfoFromJsonAdapter $giftInfo
     */
    public function setGiftInfo($giftInfo)
    {
        $this->giftInfo = $giftInfo;
    }


}