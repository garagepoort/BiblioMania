<?php


class BookExtrasToJsonAdapter
{
    /**
     * @var string
     */
    private $coverPriceCurrency;
    /**
     * @var float
     */
    private $coverPrice;
    /**
     * @var int
     */
    private $pages;
    /**
     * @var int
     */
    private $print;
    /**
     * @var string
     */
    private $translator;
    /**
     * @var string
     */
    private $state;
    /**
     * @var string
     */
    private $summary;
    /**
     * @var string
     */
    private $oldTags;
    /**
     * @var string
     */
    private $bookSeries;
    /**
     * @var string
     */
    private $publisherSeries;

    /**
     * BookExtrasToJsonAdapter constructor.
     */
    public function __construct(Book $book)
    {
        $this->coverPriceCurrency = $book->currency;
        $this->coverPrice = $book->retail_price;
        $this->pages = $book->number_of_pages;
        $this->print = $book->print;
        $this->translator = $book->translator;
        $this->oldTags = $book->old_tags;
        $this->state = $book->state;
        $this->summary = $book->summary;

        if($book->serie != null){
            $this->bookSeries = $book->serie->name;
        }
        if($book->publisher_serie != null){
            $this->publisherSeries = $book->publisher_serie->name;
        }
    }


    public function mapToJson()
    {
        return array(
            "coverPriceCurrency"=>$this->coverPriceCurrency,
            "coverPrice"=>$this->coverPrice,
            "translator"=>$this->translator,
            "state"=>$this->state,
            "oldTags"=>$this->oldTags,
            "bookSeries"=>$this->bookSeries,
            "publisherSeries"=>$this->publisherSeries,
            "summary"=>$this->summary,
            "print"=>$this->print,
            "pages"=>$this->pages,
        );
    }

}