<?php

class FirstPrintController extends BaseController
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

    public function getAllFirstPrintInfos(){
        return array_map(function($item){
            $adapter = new FirstPrintToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->firstPrintInfoRepository->all()->all());
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

    public function updateBookBasics(){
        $updateBookBasicsRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateBookBasicsFromJsonAdapter());

        $book = $this->bookBasicsService->updateBookBasics($updateBookBasicsRequest);
        return $book->id;
    }

    public function createBookBasics(){
        $createBookBasicsRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new CreateBookBasicsFromJsonAdapter());

        $book = $this->bookBasicsService->createBookBasics($createBookBasicsRequest);
        return $book->id;
    }

}