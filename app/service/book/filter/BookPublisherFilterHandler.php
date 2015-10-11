<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;

class BookPublisherFilterHandler implements OptionsFilterHandler
{

    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder
            ->leftJoin("publisher", "book.publisher_id", "=", "publisher.id")
            ->whereIn("publisher.id", $value);
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
        $options["Geen waarde"] = "";
        foreach($publishers as $publisher){
            if(!StringUtils::isEmpty($publisher->name)){
                $options[$publisher->name] = $publisher->id;
            }else{
                $options["Geen waarde"] = $publisher->id;
            }
        }
        return $options;
    }

    public function getSupportedOperators()
    {
        return array("in"=>FilterOperator::IN);
    }

    public function getGroup()
    {
        return "book";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}