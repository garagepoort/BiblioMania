<?php

class ReadingDateToJsonAdapter
{

    /** @var int */
    private $id;
    /** @var DateToJsonAdapter */
    private $date;

    /** @var string */
    private $review;
    /** @var int */
    private $rating;

    /**
     * DateToJsonAdapter constructor.
     */
    public function __construct(ReadingDate $date)
    {
        $this->id = $date->id;
        $this->date = DateToJsonAdapter::fromDate($date->date);
        $this->review = $date->review;
        $this->rating = $date->rating;
    }

    public function mapToJson()
    {
        return array(
            "id" => $this->id,
            "date" => $this->date->mapToJson(),
            "rating" => $this->rating,
            "review" => $this->review
        );
    }
}