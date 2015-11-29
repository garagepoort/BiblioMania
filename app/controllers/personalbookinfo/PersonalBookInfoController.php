<?php

class PersonalBookInfoController extends BaseController
{
    /** @var  PersonalBookInfoService */
    private $personalBookInfoService;
    /** @var  FirstPrintInfoService */
    private $firstPrintInfoService;
    /** @var  JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    public function __construct()
    {
        $this->firstPrintInfoService = App::make('FirstPrintInfoService');
        $this->personalBookInfoService = App::make('PersonalBookInfoService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function addReadingDate($personalBookInfoId){
        $date = $this->jsonMappingService->mapInputToJson(Input::get(), new DateFromJsonAdapter());
        $this->personalBookInfoService->addReadingDate($personalBookInfoId, $date);
    }
    public function deleteReadingDate($personalBookInfoId){
        $deleteDateRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new DeleteReadingDateFromJsonAdapter());
        $this->personalBookInfoService->deleteReadingDate($personalBookInfoId, $deleteDateRequest);
    }

    public function getReadingDates($personalBookInfoId){
        /** @var PersonalBookInfo $personalBookInfo */
        $personalBookInfo = $this->personalBookInfoService->find($personalBookInfoId);
        Ensure::objectNotNull('personal book info', $personalBookInfoId);

        return array_map(function($date){
            $readingDateToJson = new ReadingDateToJsonAdapter($date);
            return $readingDateToJson->mapToJson();
        }, $personalBookInfo->reading_dates->all());
    }


}