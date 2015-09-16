<?php

class GiftInfoParameters {
    private $date;
    private $from;
    private $occasion;
    private $reason;

    function __construct(DateTime $date = null, $from, $occasion, $reason)
    {
        $this->date = $date;
        $this->from = $from;
        $this->occasion = $occasion;
        $this->reason = $reason;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getOccasion()
    {
        return $this->occasion;
    }

    public function getReason()
    {
        return $this->reason;
    }
}