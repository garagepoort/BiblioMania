<?php

class PublisherJsonMapper
{

    public function mapToJson(Publisher $publisher){
        /** @var PublisherData $publisherData */
        $publisherData = new PublisherData();
        $publisherData->setName($publisher->name);
        return $publisherData->toJson();
    }

    public function mapArrayToJson($publishers){
        $result = array();
        foreach($publishers as $publisher){
            array_push($result, $this->mapToJson($publisher));
        }
        return $result;
    }
}