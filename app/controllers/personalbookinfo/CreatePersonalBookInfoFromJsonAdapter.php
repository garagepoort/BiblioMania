<?php

class CreatePersonalBookInfoFromJsonAdapter implements CreatePersonalBookInfoRequest
{
    /** @var  int */
    /** @required   */
    private $bookId;
    /** @var  int */
    private $rating = 0;
    /** @var  string */
    private $review;
    /** @var  boolean */
    private $inCollection;
    /** @var  string */
    private $reasonNotInCollection;
    /** @var  CreateBuyInfoFromJsonAdapter */
    private $buyInfo;
    /** @var  CreateGiftInfoFromJsonAdapter */
    private $giftInfo;

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
     * @return CreateBuyInfoFromJsonAdapter
     */
    public function getBuyInfo()
    {
        return $this->buyInfo;
    }

    /**
     * @param CreateBuyInfoFromJsonAdapter $buyInfo
     */
    public function setBuyInfo($buyInfo)
    {
        $this->buyInfo = $buyInfo;
    }

    /**
     * @return CreateGiftInfoFromJsonAdapter
     */
    public function getGiftInfo()
    {
        return $this->giftInfo;
    }

    /**
     * @param CreateGiftInfoFromJsonAdapter $giftInfo
     */
    public function setGiftInfo($giftInfo)
    {
        $this->giftInfo = $giftInfo;
    }


}