<?php

class GiftInfoParameters {
    private $date;
    private $from;
    private $occasion;

    function __construct(DateTime $date = null, $from, $occasion)
    {
        $this->date = $date;
        $this->from = $from;
        $this->occasion = $occasion;
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


}