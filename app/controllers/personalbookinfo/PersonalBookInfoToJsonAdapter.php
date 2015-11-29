<?php

class PersonalBookInfoToJsonAdapter
{
    private $id;
    private $read;
    private $review;
    private $rating;
    /** @var  ReadingDateToJsonAdapter[] */
    private $readingDates;
    /** @var  BuyInfoToJsonAdapter */
    private $buyInfo;
    /** @var  GiftInfoToJsonAdapter */
    private $giftInfo;

    public function __construct(PersonalBookInfo $personalBookInfo)
    {
        $this->id = $personalBookInfo->id;
        $this->read = $personalBookInfo->read;
        $this->review = $personalBookInfo->review;
        $this->rating = $personalBookInfo->rating;

        $this->readingDates = array_map(function ($date) {
            return new ReadingDateToJsonAdapter($date);
        }, $personalBookInfo->reading_dates->all());

        if ($personalBookInfo->buy_info != null) {
            $this->buyInfo = new BuyInfoToJsonAdapter($personalBookInfo->buy_info);
        } else {
            if ($personalBookInfo->gift_info != null) {
                $this->giftInfo = new GiftInfoToJsonAdapter($personalBookInfo->gift_info);
            }
        }
    }

    public function mapToJson()
    {
        $result = array(
            "id" => $this->id,
            "read" => $this->read ? true : false,
            "review" => $this->review,
            "rating" => $this->rating,
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