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

    public function get($id){
        $personalBookInfo = $this->personalBookInfoService->find($id);
        Ensure::objectNotNull('personalBookInfo', $personalBookInfo);

        $personalBookInfoToJsonAdapter = new PersonalBookInfoToJsonAdapter($personalBookInfo);
        return $personalBookInfoToJsonAdapter->mapToJson();
    }

    public function create(){
        $adapter = $this->jsonMappingService->mapInputToJson(Input::get(), new CreatePersonalBookInfoFromJsonAdapter());
        $id = $this->personalBookInfoService->createPersonalBookInfo($adapter);
        return Response::json(array('success' => true, 'id' => $id), 200);
    }

    public function update(){
        $adapter = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdatePersonalBookInfoFromJsonAdapter());
        $id = $this->personalBookInfoService->update($adapter);
        return Response::json(array('success' => true, 'id' => $id), 200);
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