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
                         array $authorInfoParameters,
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
    public function getFirstAuthorInfoParameters()
    {
        return $this->authorInfoParameters[0];
    }

    public function getSecondaryAuthorsInfoParameters()
    {
        if(count($this->authorInfoParameters) == 1){
            return array();
        }
        return array_slice($this->authorInfoParameters, 1);
    }

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

    public function getBuyInfoParameters()
    {
        return $this->buyInfoParameters;
    }

    public function getGiftInfoParameters()
    {
        return $this->giftInfoParameters;
    }

    public function getCoverInfoParameters()
    {
        return $this->coverInfoParameters;
    }

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