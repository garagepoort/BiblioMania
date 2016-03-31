<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilter;

class BookAuthorFilter implements OptionsFilter
{

    public function getFilterId()
    {
        return FilterType::BOOK_AUTHOR;
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