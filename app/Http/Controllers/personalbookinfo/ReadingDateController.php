<?php

class ReadingDateController extends Controller
{

    /** @var  ReadingDateService */
    private $readingDateService;
    /** @var  JsonMappingService */
    private $jsonMappingService;

    public function __construct()
    {
        $this->readingDateService = App::make('ReadingDateService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function createReadingDate(){
        /** @var BaseReadingDateRequest $date */
        $date = $this->jsonMappingService->mapInputToJson(Input::get(), new ReadingDateFromJsonAdapter());
        $id = $this->readingDateService->createReadingDate($date);
        return Response::json(array('success' => true, 'id' => $id), 200);
    }

    public function updateReadingDate(){
        /** @var UpdateReadingDateRequest $date */
        $date = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateReadingDateFromJsonAdapter());
        $id = $this->readingDateService->updateReadingDate($date);
        return Response::json(array('success' => true, 'id' => $id), 200);
    }

    public function deleteReadingDate($id){
        $this->readingDateService->deleteReadingDate($id);
    }
}