<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookTagFilterHandler implements OptionsFilterHandler
{

    public function handleFilter(Filter $filter)
    {
//        Ensure::objectNotNull('selected options', $filter->getValue());
//
//        $options = array_map(function($item){ return $item->value; }, (array) $filter->getValue());
//
//        return $queryBuilder->whereIn("book_tag.tag_id", $options);
    }

    public function getFilterId()
    {
        return "book-tag";
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

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder->join('book_tag', 'book.id', '=', 'book_tag.book_id');
    }
}