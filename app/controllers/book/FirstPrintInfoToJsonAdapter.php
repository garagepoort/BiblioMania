<?php

class FirstPrintInfoToJsonAdapter
{

    private $id;
    private $title;
    private $isbn;
    private $subtitle;
    private $publisher;
    private $country;
    private $language;

    /** @var  DateToJsonAdapter */
    private $publicationDate;

    /**
     * FirstPrintInfoToJsonAdapter constructor.
     */
    public function __construct(FirstPrintInfo $firstPrintInfo)
    {
        $this->id = $firstPrintInfo->id;
        $this->title = $firstPrintInfo->title;
        $this->subtitle = $firstPrintInfo->subtitle;
        $this->isbn = $firstPrintInfo->ISBN;
        $this->publisher = $firstPrintInfo->publisher == null ? null : $firstPrintInfo->publisher->name;
        $this->country = $firstPrintInfo->country == null ? null : $firstPrintInfo->country->name;
        $this->language = $firstPrintInfo->language == null ? null : $firstPrintInfo->language->language;
        if($firstPrintInfo->publication_date != null){
            $this->publicationDate = new DateToJsonAdapter($firstPrintInfo->publication_date);
        }

    }


    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "isbn" => $this->isbn,
            "subtitle" => $this->subtitle,
            "publisher" => $this->publisher,
            "country" => $this->country,
            "language" => $this->language
        );

        if($this->publicationDate != null){
            $result['publicationDate'] = $this->publicationDate->mapToJson();
        }

        return $result;
    }
}