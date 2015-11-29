<?php

class ReadingDateToJsonAdapter
{

    /** @var int */
    private $id;
    /** @var DateToJsonAdapter */
    private $date;

    /**
     * DateToJsonAdapter constructor.
     */
    public function __construct(ReadingDate $date)
    {
        $this->id = $date->id;
        $this->date = DateToJsonAdapter::fromDate($date->date);
    }

    public function mapToJson()
    {
        return array(
            "id" => $this->id,
            "date" => $this->date->mapToJson()
        );
    }
}