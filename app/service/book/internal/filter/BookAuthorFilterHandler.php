<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookAuthorFilterHandler implements OptionsFilterHandler
{

    public function handleFilter(Filter $filter)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){ return $item->value; }, (array) $filter->getValue());

        return FilterBuilder::terms('authors.id', $options);
    }

    public function getFilterId()
    {
        return "book-author";
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Auteur";
    }

    public function getOptions()
    {
        /** @var AuthorRepository $authorRepository */
        $authorRepository = App::make("AuthorRepository");
        $authors = $authorRepository->all();
        $options = array();
        foreach($authors as $author){
            array_push($options, array("key"=>$author->firstname . ' ' . $author->name, "value"=>$author->id));
        }
        return $options;
    }

    public function getSupportedOperators(){ return null;}

    public function getGroup()
    {
        return "book";
    }

}