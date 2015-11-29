<?php

class GiftInfoToJsonAdapter
{
    private $id;
    private $from;
    private $occasion;
    private $reason;

    /** @var  DateToJsonAdapter $date */
    private $date;

    public function __construct(GiftInfo $giftInfo)
    {
        $this->id = $giftInfo->id;
        $this->from = $giftInfo->from;
        $this->occasion = $giftInfo->occasion;
        $this->reason = $giftInfo->reason;
        if($giftInfo->gift_date != null){
            $this->date = DateToJsonAdapter::fromDate($giftInfo->gift_date);
        }
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "from" => $this->from,
            "occasion" => $this->occasion,
            "reason" => $this->reason,
        );
        if($this->date != null){
            $result['date'] = $this->date->mapToJson();
        }
        return $result;
    }
}