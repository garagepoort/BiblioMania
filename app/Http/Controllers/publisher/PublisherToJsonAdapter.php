<?php

class PublisherToJsonAdapter
{
    private $id;
    private $name;
    private $books;
    private $firstPrintInfos;

    public function __construct(Publisher $publisher)
    {
        $this->id = $publisher->id;
        $this->name = $publisher->name;
        $this->books = array_map(function($book){ return $book->id; }, $publisher->books->all());;
        $this->firstPrintInfos = array_map(function($firstPrint){ return $firstPrint->id; }, $publisher->first_print_infos->all());;
    }

    public function mapToJson(){
        return array(
            "id"=>$this->id,
            "name"=>$this->name,
            "books" => $this->books,
            "firstPrintInfos" => $this->firstPrintInfos
        );
    }

}