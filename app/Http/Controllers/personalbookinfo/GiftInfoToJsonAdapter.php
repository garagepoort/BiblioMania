<?php

class GiftInfoToJsonAdapter
{
    private $id;
    private $from;
    private $occasion;
    private $reason;

    /** @var  DateToJsonAdapter $date */
    private $giftDate;

    public function __construct(GiftInfo $giftInfo)
    {
        $this->id = $giftInfo->id;
        $this->from = $giftInfo->from;
        $this->occasion = $giftInfo->occasion;
        $this->reason = $giftInfo->reason;
        if($giftInfo->receipt_date != null){
            $this->giftDate = DateToJsonAdapter::fromDate($giftInfo->receipt_date);
        }
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "from" => $this->from,
            "occasion" => $this->occasion,
            "reason" => $this->reason,
        );
        if($this->giftDate != null){
            $result['giftDate'] = $this->giftDate->mapToJson();
        }
        return $result;
    }
}