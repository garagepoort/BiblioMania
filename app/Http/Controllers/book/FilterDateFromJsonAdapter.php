<?php
use Bendani\PhpCommon\FilterService\Model\FilterDateRequest;

class FilterDateFromJsonAdapter implements FilterDateRequest
{
    /** @var  DateFromJsonAdapter */
    private $from;
    /** @var  DateFromJsonAdapter */
    private $to;

    /**
     * @return DateFromJsonAdapter
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param DateFromJsonAdapter $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return DateFromJsonAdapter
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param DateFromJsonAdapter $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }


}