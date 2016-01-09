<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookGenreFilterHandler implements OptionsFilterHandler
{
    /** @var  GenreService $genreService */
    private $genreService;
    /**
     * BookCountryFilterHandler constructor.
     */
    public function __construct()
    {
        $this->genreService = App::make('GenreService');
    }

    public function handleFilter(Filter $filter)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){ return $item->value; }, (array) $filter->getValue());

        return FilterBuilder::terms('genre', $options);
    }

    public function getFilterId()
    {
        return "book-genre";
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Genre";
    }

    public function getOptions()
    {
        $options= array();
        $noValueOption = array("key" => "Geen waarde", "value" => "");
        array_push($options, $noValueOption);
        foreach($this->genreService->getAllGenres() as $genre){
            if(!StringUtils::isEmpty($genre->name)){
                array_push($options, array("key"=>$genre->name, "value"=>$genre->id));
            }else{
                $noValueOption["value"] = $genre->id;
            }
        }
        return $options;
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "book";
    }
}