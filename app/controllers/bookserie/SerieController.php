<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/01/15
 * Time: 20:42
 */
class SerieController extends BaseController
{

    /** @var BookSerieService $bookSerieService */
    private $bookSerieService;

    function __construct()
    {
        $this->bookSerieService = App::make('BookSerieService');
    }

    public function getSeries(){
        return array_map(function($item){
            $adapter = new SerieToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->bookSerieService->getSeries()->all());
    }
}