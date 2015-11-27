<?php

class PublisherToJsonAdapter
{
    private $id;
    private $name;

    public function __construct(Publisher $publisher)
    {
        $this->id = $publisher->id;
        $this->name = $publisher->name;
    }

    public function mapToJson(){
        return array(
            "id"=>$this->id,
            "name"=>$this->name
        );
    }

}