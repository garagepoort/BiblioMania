<?php

class PublisherSerieController extends BaseController
{

    /** @var PublisherSerieService $publisherSerieService */
    private $publisherSerieService;
    /** @var JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    function __construct()
    {
        $this->publisherSerieService = App::make('PublisherSerieService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getPublisherSeries(){
        return array_map(function($item){
            $adapter = new PublisherSerieToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->publisherSerieService->getPublisherSeries()->all());
    }

    public function deleteSerie($id){
        $this->publisherSerieService->deleteSerie($id);
    }

    public function updateSerie(){
        $this->publisherSerieService->update($this->jsonMappingService->mapInputToJson(Input::get(), new UpdateSerieFromJsonAdapter()));
    }

    public function addBookToSerie($serieId){
        /** @var BookIdFromJsonAdapter $bookIdFromJsonAdapter */
        $bookIdFromJsonAdapter = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->publisherSerieService->addBookToSerie($serieId, $bookIdFromJsonAdapter);
    }

    public function removeBookFromSerie($serieId){
        /** @var BookIdFromJsonAdapter $bookIdFromJsonAdapter */
        $bookIdFromJsonAdapter = $this->jsonMappingService->mapInputToJson(Input::get(), new BookIdFromJsonAdapter());
        $this->publisherSerieService->removeBookFromSerie($serieId, $bookIdFromJsonAdapter);
    }
}