<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilter;

class BookTagFilter implements OptionsFilter
{

    public function getFilterId()
    {
        return FilterType::BOOK_TAG;
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Tags";
    }

    public function getOptions()
    {
        /** @var TagService $tagService */
        $tagService = App::make("TagService");
        $tags = $tagService->getAllTags();
        $options = array();
        foreach($tags as $tag){
            array_push($options, array("key"=>$tag->name, "value"=>$tag->id));
        }
        return $options;
    }

    public function getSupportedOperators(){ return null;}

    public function getGroup()
    {
        return "book";
    }

}