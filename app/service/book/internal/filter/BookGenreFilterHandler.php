<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
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

    public function handleFilter($queryBuilder, Filter $filter)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){
            return $item->value;
        }, (array) $filter->getValue());

        return $queryBuilder
            ->leftJoin('genre', 'genre.id', '=', 'book.genre_id')
            ->whereIn("genre.name", $options);
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
                array_push($options, array("key"=>$genre->name, "value"=>$genre->name));
            }else{
                $noValueOption["value"] = $genre->name;
            }
        }
        return $options;
    }

    public function getSupportedOperators()
    {
        return array(
            array("key"=>"in", "value"=>FilterOperator::IN)
        );
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