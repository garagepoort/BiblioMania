<?php

class SerieToJsonAdapter
{

    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var integer */
    private $publisherId;
    /** @var BookToJsonAdapter[] */
    private $books;

    public function __construct(Serie $serie)
    {
        $this->id = $serie->id;
        $this->name = $serie->name;
        $this->publisherId = $serie->publisher_id;
        $this->books = array_map(function($book){
            return new BookToJsonAdapter($book);
        }, $serie->books->all());
    }

    public function mapToJson(){
        return array(
            'id'=>$this->id,
            'name'=>$this->name,
            'publisherId'=>$this->publisherId,
            'books'=>array_map(function($bookToJsonAdapter){ return $bookToJsonAdapter->mapToJson(); }, $this->books)
        );
    }
}