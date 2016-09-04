<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilter;
use Bendani\PhpCommon\Utils\StringUtils;

class BookPublisherFilter implements OptionsFilter
{

    public function getFilterId()
    {
        return FilterType::BOOK_PUBLISHER;
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