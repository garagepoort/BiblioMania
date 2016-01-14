<?php

class PublisherSerieToJsonAdapter
{
    private $id;
    private $name;
    private $publisherId;
    private $books;

    public function __construct(PublisherSerie $publisherSerie)
    {
        $this->id = $publisherSerie->id;
        $this->name = $publisherSerie->name;
        $this->publisherId = $publisherSerie->publisher_id;
        $this->books = array_map(function($book){
            return new BookToJsonAdapter($book);
        }, $publisherSerie->books->all());
    }

    public function mapToJson(){
        return array(
            "id"=>$this->id,
            "name"=>$this->name,
            "publisherId"=>$this->publisherId,
            'books'=>array_map(function($bookToJsonAdapter){ return $bookToJsonAdapter->mapToJson(); }, $this->books)
        );
    }

}