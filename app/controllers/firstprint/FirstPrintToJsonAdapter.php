<?php


class FirstPrintToJsonAdapter
{
    /** @var  int */
    private $id;
    /** @var  string */
    private $title;
    /** @var  string */
    private $subtitle;
    /** @var  string */
    private $isbn;
    /** @var  DateToJsonAdapter */
    private $publicationDate;
    /** @var  string */
    private $publisher;
    /** @var  string */
    private $language;
    /** @var  string */
    private $country;

    /**
     * BookBasicsToJsonAdapter constructor.
     * @param FirstPrintInfo $firstPrint
     */
    public function __construct(FirstPrintInfo $firstPrint)
    {
        $this->id = $firstPrint->id;
        $this->title = $firstPrint->title;
        $this->subtitle = $firstPrint->subtitle;
        $this->isbn = $firstPrint->ISBN;

        if($firstPrint->publication_date != null){
            $this->publicationDate = new DateToJsonAdapter($firstPrint->publication_date);
        }
        if ($firstPrint->publisher != null) {
            $this->publisher = $firstPrint->publisher->name;
        }
        if ($firstPrint->language != null) {
            $this->language = $firstPrint->language->language;
        }
        if ($firstPrint->country != null) {
            $this->country = $firstPrint->country->name;
        }
    }

    public function mapToJson(){
        $result = array(
            "id"=>$this->id,
            "title"=>$this->title,
            "subtitle"=>$this->subtitle,
            "isbn"=>$this->isbn,
            "language"=>$this->language,
            "publisher"=>$this->publisher,
            "country"=>$this->country
        );

        if($this->publicationDate != null){
            $result["publicationDate"] = $this->publicationDate->mapToJson();
        }

        return $result;
    }
}