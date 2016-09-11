<?php

class ReadingDateFromJsonAdapter implements BaseReadingDateRequest
{

    /** @var  DateFromJsonAdapter */
    private $date;
    /** @var  int */
    private $rating;
    /** @var  string */
    private $review;
    /** @var  int */
    private $personalBookInfoId;

    /**
     * @return DateFromJsonAdapter
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateFromJsonAdapter $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return string
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @param string $review
     */
    public function setReview($review)
    {
        $this->review = $review;
    }

    /**
     * @return int
     */
    public function getPersonalBookInfoId()
    {
        return $this->personalBookInfoId;
    }

    /**
     * @param int $personalBookInfoId
     */
    public function setPersonalBookInfoId($personalBookInfoId)
    {
        $this->personalBookInfoId = $personalBookInfoId;
    }


}