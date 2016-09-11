<?php

class PersonalBookInfoToJsonAdapter
{
    private $id;
    private $bookId;
    private $read;
    private $inCollection;
    private $reasonNotInCollection;
    private $acquirement;

    /** @var  ReadingDateToJsonAdapter[] */
    private $readingDates;
    /** @var  BuyInfoToJsonAdapter */
    private $buyInfo;
    /** @var  GiftInfoToJsonAdapter */
    private $giftInfo;

    public function __construct(PersonalBookInfo $personalBookInfo)
    {
        $this->id = $personalBookInfo->id;
        $this->bookId = $personalBookInfo->book_id;
        $this->read = count($personalBookInfo->reading_dates->all()) > 0;
        $this->inCollection = $personalBookInfo->get_owned();
        $this->reasonNotInCollection = $personalBookInfo->reason_not_owned;

        $this->readingDates = array_map(function ($date) {
            return new ReadingDateToJsonAdapter($date);
        }, $personalBookInfo->reading_dates->all());

        if ($personalBookInfo->buy_info != null) {
            $this->acquirement = 'BUY';
            $this->buyInfo = new BuyInfoToJsonAdapter($personalBookInfo->buy_info);
        } else if ($personalBookInfo->gift_info != null) {
            $this->acquirement = 'GIFT';
            $this->giftInfo = new GiftInfoToJsonAdapter($personalBookInfo->gift_info);
        }
    }

    public function mapToJson()
    {
        $result = array(
            "id" => $this->id,
            "bookId" => $this->bookId,
            "read" => $this->read ? true : false,
            "acquirement" => $this->acquirement,
            "inCollection" => $this->inCollection,
            "reasonNotInCollection" => $this->reasonNotInCollection,
            "readingDates" => array_map(function ($date) {
                return $date->mapToJson();
            }, $this->readingDates),
        );
        if ($this->buyInfo != null) {
            $result["buyInfo"] = $this->buyInfo->mapToJson();
        }
        if ($this->giftInfo != null) {
            $result["giftInfo"] = $this->giftInfo->mapToJson();
        }

        return $result;
    }
}