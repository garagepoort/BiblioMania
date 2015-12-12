<?php

class PublisherSerieToJsonAdapter
{

    /** @var int */
    private $id;
    /** @var string */
    private $name;

    public function __construct(PublisherSerie $serie)
    {
        $this->id = $serie->id;
        $this->name = $serie->name;
    }


    public function mapToJson(){
        return array(
            'id'=>$this->id,
            'name'=>$this->name
            );
    }
}