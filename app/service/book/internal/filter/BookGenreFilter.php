<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilter;
use Bendani\PhpCommon\Utils\StringUtils;

class BookGenreFilter implements OptionsFilter
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

    public function getFilterId()
    {
        return FilterType::BOOK_GENRE;
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