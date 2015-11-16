<?php

class BookExtrasWizardStepResource extends BaseController
{
    /** @var  BookService */
    private $bookService;
    /** @var  BookExtrasService $bookExtrasService */
    private $bookExtrasService;
    /** @var  BookExtrasToJsonAdapter */
    private $bookExtrasJsonMapper;
    /** @var  JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    public function __construct()
    {
        $this->bookExtrasService = App::make('BookExtrasService');
        $this->bookService = App::make('BookService');
        $this->bookExtrasJsonMapper = App::make('BookExtrasToJsonAdapter');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getBookExtras($id){
        $fullBook = $this->bookService->getFullBook($id, array('publication_date', 'publisher_serie', 'serie'));
        if($fullBook == null){
            return ResponseCreator::createExceptionResponse(new ServiceException("Book with id not found"));
        }
        return $this->bookExtrasJsonMapper->mapToJson($fullBook);
    }

    public function updateBookExtras(){
        $updateExtrasRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateBookExtrasFromJsonAdapter());
        $book = $this->bookExtrasService->updateBookExtras($updateExtrasRequest);
        return $book->id;
    }
}