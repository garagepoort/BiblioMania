<?php

class PublisherSerieToJsonAdapter
{
    private $id;
    private $name;
    private $publisherId;

    public function __construct(PublisherSerie $publisherSerie)
    {
        $this->id = $publisherSerie->id;
        $this->name = $publisherSerie->name;
        $this->publisherId = $publisherSerie->publisher_id;
    }

    public function mapToJson(){
        return array(
            "id"=>$this->id,
            "name"=>$this->name,
            "publisherId"=>$this->publisherId
        );
    }

}