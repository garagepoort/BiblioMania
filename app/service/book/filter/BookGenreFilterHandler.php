<?php

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

    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder
            ->leftJoin('genre', 'genre.id', '=', 'book.genre_id')
            ->whereIn("genre.name", $value);
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
        $result= array();
        $result["Geen waarde"] = "";
        foreach($this->genreService->getAllGenres() as $genre){
            if(!StringUtils::isEmpty($genre->name)){
                $result[$genre->name] = $genre->name;
            }else{
                $result["Geen waarde"] = $genre->name;
            }
        }
        return $result;
    }

    public function getSupportedOperators()
    {
        return array("in"=>FilterOperator::IN);
    }

}