<?php

class BookBasicsWizardStepResource extends BaseController
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  BookBasicsService $bookBasicsService */
    private $bookBasicsService;
    /** @var  BookBasicsToJsonAdapter */
    private $bookBasicsJsonMapper;
    /** @var  JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    public function __construct()
    {
        $this->bookBasicsService = App::make('BookBasicsService');
        $this->bookService = App::make('BookService');
        $this->bookBasicsJsonMapper = App::make('BookBasicsToJsonAdapter');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getBookBasics($id){
        $fullBook = $this->bookService->getFullBook($id, array('publication_date'));
        if($fullBook == null){
            return ResponseCreator::createExceptionResponse(new ServiceException("Book with id not found"));
        }
        return $this->bookBasicsJsonMapper->mapToJson($fullBook);
    }

    public function updateBookBasics(){
        $updateBookBasicsRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateBookBasicsFromJsonAdapter());

        $this->bookBasicsService->updateBookBasics($updateBookBasicsRequest);
    }

    public function createBookBasics(){
        $updateBookBasicsRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateBookBasicsFromJsonAdapter());

        $this->bookBasicsService->updateBookBasics($updateBookBasicsRequest);
    }

}