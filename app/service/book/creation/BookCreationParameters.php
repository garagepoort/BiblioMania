<?php

class BookCreationParameters {

    private $bookInfoParameters;
    private $extraBookInfoParameters;
    private $authorInfoParameters;
    private $buyInfoParameters;
    private $giftInfoParameters;
    private $firstPrintInfoParameters;
    private $coverInfoParameters;
    private $personalBookInfoParameters;

    function __construct(BookInfoParameters $bookInfoParameters,
                         ExtraBookInfoParameters $extraBookInfoParameters,
                         AuthorInfoParameters $authorInfoParameters,
                         BuyInfoParameters $buyInfoParameters = null,
                         GiftInfoParameters $giftInfoParameters = null,
                        CoverInfoParameters $coverInfoParameters,
                        FirstPrintInfoParameters $firstPrintInfoParameters,
                        PersonalBookInfoParameters $personalBookInfoParameters)
    {
        $this->bookInfoParameters = $bookInfoParameters;
        $this->extraBookInfoParameters = $extraBookInfoParameters;
        $this->authorInfoParameters = $authorInfoParameters;
        $this->buyInfoParameters = $buyInfoParameters;
        $this->giftInfoParameters = $giftInfoParameters;
        $this->coverInfoParameters = $coverInfoParameters;
        $this->firstPrintInfoParameters = $firstPrintInfoParameters;
        $this->personalBookInfoParameters = $personalBookInfoParameters;
    }

    /**
     * @return BookInfoParameters
     */
    public function getBookInfoParameters()
    {
        return $this->bookInfoParameters;
    }

    /**
     * @return ExtraBookInfoParameters
     */
    public function getExtraBookInfoParameters()
    {
        return $this->extraBookInfoParameters;
    }

    /**
     * @return AuthorInfoParameters
     */
    public function getAuthorInfoParameters()
    {
        return $this->authorInfoParameters;
    }

    public function isBuyInfo(){
        return $this->buyInfoParameters != null;
    }


    public function isGiftInfo(){
        return $this->giftInfoParameters != null;
    }

    /**
     * @return BuyInfoParameters
     */
    public function getBuyInfoParameters()
    {
        return $this->buyInfoParameters;
    }

    /**
     * @return GiftInfoParameters
     */
    public function getGiftInfoParameters()
    {
        return $this->giftInfoParameters;
    }

    /**
     * @return CoverInfoParameters
     */
    public function getCoverInfoParameters()
    {
        return $this->coverInfoParameters;
    }

    /**
     * @return FirstPrintInfoParameters
     */
    public function getFirstPrintInfoParameters()
    {
        return $this->firstPrintInfoParameters;
    }

    /**
     * @return PersonalBookInfoParameters
     */
    public function getPersonalBookInfoParameters()
    {
        return $this->personalBookInfoParameters;
    }


}