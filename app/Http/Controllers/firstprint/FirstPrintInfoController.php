<?php

use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

class FirstPrintInfoController extends Controller
{
    /** @var  BookService */
    private $bookService;
    /** @var  FirstPrintInfoService */
    private $firstPrintInfoService;
    /** @var  FirstPrintInfoRepository */
    private $firstPrintInfoRepository;
    /** @var  JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    public function __construct()
    {
        $this->firstPrintInfoService = App::make('FirstPrintInfoService');
        $this->firstPrintInfoRepository = App::make('FirstPrintInfoRepository');
        $this->bookService = App::make('BookService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getFirstPrintInfo($id){
        $firstPrint = $this->firstPrintInfoRepository->find($id);
        Ensure::objectNotNull('first print info', $firstPrint);
        $adapter = new FirstPrintToJsonAdapter($firstPrint);
        return $adapter->mapToJson();
    }

    public function getAllFirstPrintInfos(){
        return array_map(function($item){
            $adapter = new FirstPrintToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->firstPrintInfoRepository->all()->all());
    }

    public function createFirstPrintInfo(){
        $createFirstPrint = $this->jsonMappingService->mapInputToJson(Input::get(), new CreateFirstPrintFromJsonAdapter());
        $id = $this->firstPrintInfoService->createFirstPrintInfo(Auth::user()->id, $createFirstPrint)->id;
        return Response::json(array('success' => true, 'id' => $id), 200);
    }

    public function linkBookToFirstPrintInfo($id){
        $linkBookRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new LinkBookToFirstPrintFromJsonAdapter());
        $this->firstPrintInfoService->linkBook($id, $linkBookRequest);
    }

    public function updateFirstPrintInfo(){
        /** @var UpdateFirstPrintInfoRequest $updateFirstPrint */
        $updateFirstPrint = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateFirstPrintFromJsonAdapter());
        $id = $this->firstPrintInfoService->updateFirstPrintInfo(Auth::user()->id, $updateFirstPrint)->id;
        return Response::json(array('success' => true, 'id' => $id), 200);
    }

    public function getFirstPrintInfoByBook($bookId){
        /** @var Book $fullBook */
        $fullBook = $this->bookService->getFullBook($bookId);
        if($fullBook == null){
            throw new ServiceException("Book with id not found");
        }
        $firstPrintToJsonAdapter = new FirstPrintToJsonAdapter($fullBook->first_print_info);
        return $firstPrintToJsonAdapter->mapToJson();
    }
}