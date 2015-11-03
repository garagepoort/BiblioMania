<?php

class PersonalBookInfoJsonMapper
{
    /** @var  GiftInfoJsonMapper $giftInfoJsonMapper*/
    private $giftInfoJsonMapper;
    /** @var  BuyInfoJsonMapper $buyInfoJsonMapper*/
    private $buyInfoJsonMapper;
    /** @var  DateToJsonMapper $dateToJsonMapper */
    private $dateToJsonMapper;

    public function __construct()
    {
        $this->giftInfoJsonMapper = App::make('GiftInfoJsonMapper');
        $this->buyInfoJsonMapper = App::make('BuyInfoJsonMapper');
        $this->dateToJsonMapper = App::make('DateToJsonMapper');
    }

    public function mapToJson(PersonalBookInfo $personalBookInfo){
        $jsonArray = array(
            "id" => $personalBookInfo->id,
            "read" => $personalBookInfo->read,
            "review" => $personalBookInfo->review,
            "rating" => $personalBookInfo->rating,
        );
        if($personalBookInfo->read){
            $jsonArray["readingDate"] = $this->dateToJsonMapper->mapToJson($personalBookInfo->reading_dates[0]->date);
        }
        $buy_info = $personalBookInfo->buy_info;
        if($buy_info != null){
            $jsonArray["buyInfo"] = $this->buyInfoJsonMapper->mapToJson($buy_info);
        }else{
            $gift_info = $personalBookInfo->gift_info;
            if($gift_info != null){
                $jsonArray["giftInfo"] = $this->giftInfoJsonMapper->mapToJson($gift_info);
            }
        }

        return $jsonArray;
    }
}