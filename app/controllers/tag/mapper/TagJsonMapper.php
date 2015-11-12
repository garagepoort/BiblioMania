<?php

class TagJsonMapper
{

    public function mapToJson(Tag $tag){
        /** @var TagData $tagData */
        $tagData = new TagData();
        $tagData->setText($tag->name);
        return $tagData->toJson();
    }

    public function mapArrayToJson($tags){
        $result = array();
        foreach($tags as $tag){
            array_push($result, $this->mapToJson($tag));
        }
        return $result;
    }
}