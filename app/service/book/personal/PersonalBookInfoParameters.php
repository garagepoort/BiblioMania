<?php

class PersonalBookInfoParameters {

    private $owned;
    private $reason_not_owned;
    private $review;
    private $rating;
    private $reading_dates;

    function __construct($owned, $reason_not_owned, $review, $rating, array $reading_dates)
    {
        $this->owned = $owned;
        $this->reason_not_owned = $reason_not_owned;
        $this->review = $review;
        $this->rating = $rating;
        $this->reading_dates = $reading_dates;
    }

    public function getOwned()
    {
        return $this->owned;
    }

    public function getReasonNotOwned()
    {
        return $this->reason_not_owned;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getReadingDates()
    {
        return $this->reading_dates;
    }



}