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
    /** @var JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    function __construct()
    {
        $this->bookSerieService = App::make('BookSerieService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getSeries(){
        return array_map(function($item){
            $adapter = new SerieToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->bookSerieService->getSeries()->all());
    }

    public function updateSerie(){
        $updateSerieRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateSerieFromJsonAdapter());
        $this->bookSerieService->update($updateSerieRequest);
    }

    public function deleteSerie($id){
        $this->bookSerieService->deleteSerie($id);
    }

    public function addBookToSerie($serieId){
        $mapInputToJson = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->bookSerieService->addBookToSerie($serieId, $mapInputToJson);
    }

    public function removeBookFromSerie($serieId){
        $mapInputToJson = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->bookSerieService->removeBookFromSerie($serieId, $mapInputToJson);
    }

}