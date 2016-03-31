<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\StringUtils;

class BookPublisherFilterHandler implements FilterHandler
{

    public function handleFilter(FilterValue $filter, $object = null)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){
            return $item->value;
        }, (array) $filter->getValue());

        return FilterBuilder::terms('publisher', $options);
    }

    public function getFilterId()
    {
        return "book-publisher";
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Uitgever";
    }

    public function getOptions()
    {
        /** @var PublisherService $publisherService */
        $publisherService = App::make("PublisherService");
        $publishers = $publisherService->getPublishers();
        $options = array();
        $noValueOption = array("key" => "Geen waarde", "value" => "");
        array_push($options, $noValueOption);
        foreach($publishers as $publisher){
            if(!StringUtils::isEmpty($publisher->name)){
                array_push($options, array("key"=>$publisher->name, "value"=>$publisher->id));
            }else{
                $noValueOption["value"] = $publisher->id;
            }
        }
        return $options;
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "book";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}