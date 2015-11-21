<?php

class BookBasicsWizardStepResource extends BaseController
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  BookBasicsService $bookBasicsService */
    private $bookBasicsService;
    /** @var  JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    public function __construct()
    {
        $this->bookBasicsService = App::make('BookBasicsService');
        $this->bookService = App::make('BookService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getBookBasics($id){
        $fullBook = $this->bookService->getFullBook($id, array('publication_date'));
        if($fullBook == null){
            throw new ServiceException("Book with id not found");
        }
        $bookBasicsToJsonAdapter = new BookBasicsToJsonAdapter($fullBook);
        return $bookBasicsToJsonAdapter->mapToJson();
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