<?php

class GiftInfoRequestTestImpl implements GiftInfoRequest
{

    /** @var Date $giftDate */
    private $giftDate;
    private $reason;
    private $occasion;
    private $from;

    /**
     * @return DateRequest
     */
    function getGiftDate()
    {
        return $this->giftDate;
    }

    function getReason()
    {
        return $this->reason;
    }

    function getOccasion()
    {
        return $this->occasion;
    }

    function getFrom()
    {
        return $this->from;
    }

    /**
     * @param Date $giftDate
     */
    public function setGiftDate($giftDate)
    {
        $this->giftDate = $giftDate;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @param mixed $occasion
     */
    public function setOccasion($occasion)
    {
        $this->occasion = $occasion;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }


}