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
        return $queryBuilder->where("genre.name", "=", $value);
    }

    public function getFilterId()
    {
        return "book.genre";
    }

    public function getType()
    {
        return "options";
    }

    public function getField()
    {
        return "Genre";
    }

    public function getOptions()
    {
        $result= array();
        foreach($this->genreService->getAllGenres() as $genre){
            $result[$genre->name] = $genre->name;
        }
        return $result;
    }

    public function getSupportedOperators()
    {
        return array("="=>FilterOperator::EQUALS);
    }
}