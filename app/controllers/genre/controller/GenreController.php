<?php

use Bendani\PhpCommon\Utils\StringUtils;

class GenreController extends BaseController
{

    /** @var  GenreService $genreService */
    private $genreService;
    /** @var  GenreJsonMapper $genreJsonMapper*/
    private $genreJsonMapper;

    public function __construct()
    {
        $this->genreService = App::make('GenreService');
        $this->genreJsonMapper = App::make('GenreJsonMapper');
    }

    public function getGenres(){
        return $this->genreJsonMapper->mapArrayToJson($this->genreService->getAllRootGenres());
    }
}