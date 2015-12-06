<?php

class CreateGiftInfoFromJsonAdapter implements CreateGiftInfoRequest
{

    /** @var  DateFromJsonAdapter */
    private $giftDate;
    /** @var  string */
    private $reason;
    /** @var  string */
    private $occasion;
    /** @var  string */
    private $from;

    /**
     * @return DateFromJsonAdapter
     */
    public function getGiftDate()
    {
        return $this->giftDate;
    }

    /**
     * @param DateFromJsonAdapter $giftDate
     */
    public function setGiftDate($giftDate)
    {
        $this->giftDate = $giftDate;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getOccasion()
    {
        return $this->occasion;
    }

    /**
     * @param string $occasion
     */
    public function setOccasion($occasion)
    {
        $this->occasion = $occasion;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }


}