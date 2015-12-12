<?php

class PublisherSerieController extends BaseController
{

    /** @var PublisherSerieService $publisherSerieService */
    private $publisherSerieService;

    function __construct()
    {
        $this->publisherSerieService = App::make('PublisherSerieService');
    }

    public function getPublisherSeries(){
        return array_map(function($item){
            $adapter = new PublisherSerieToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->publisherSerieService->getPublisherSeries()->all());
    }
}