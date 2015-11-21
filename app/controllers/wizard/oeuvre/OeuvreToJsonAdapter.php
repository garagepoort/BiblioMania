<?php

class OeuvreToJsonAdapter
{

    /** @var OeuvreItemToJsonAdapter[] */
    private $oeuvreItems;

    /**
     * OeuvreToJsonAdapter constructor.
     */
    public function __construct(Author $author)
    {
        $this->oeuvreItems = array_map(function($item){
            return new OeuvreItemToJsonAdapter($item);
        }, $author->oeuvre->all());
    }

    public function mapToJson(){
        return array_map(function($item){
            /** @var OeuvreItemToJsonAdapter $item*/
            return $item->mapToJson();
        }, $this->oeuvreItems);
    }
}