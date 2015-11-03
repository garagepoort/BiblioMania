<?php

class GiftInfoJsonMapper
{
    /** @var  DateToJsonMapper $dateToJsonMapper */
    private $dateToJsonMapper;

    public function __construct()
    {
        $this->dateToJsonMapper = App::make('DateToJsonMapper');
    }

    public function mapToJson(GiftInfo $giftInfo){
        return array(
            "id" => $giftInfo->id,
            "date" => $this->dateToJsonMapper->mapToJson($giftInfo->gift_date),
            "from" => $giftInfo->from,
            "occasion" => $giftInfo->occasion,
            "reason" => $giftInfo->reason,
        );
    }
}