<?php

class BookAuthorWizardStepResource extends BaseController
{
    /** @var  BookService */
    private $bookService;
    /** @var  BookAuthorService $bookAuthorService */
    private $bookAuthorService;
    /** @var  JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    public function __construct()
    {
        $this->bookAuthorService = App::make('BookAuthorService');
        $this->bookService = App::make('BookService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getBookAuthor($id){
        $fullBook = $this->bookService->getFullBook($id, array('publication_date', 'publisher_serie', 'serie'));
        if($fullBook == null){
            return ResponseCreator::createExceptionResponse(new ServiceException("Book with id not found"));
        }
        $bookAuthorToJsonAdapter = new BookAuthorToJsonAdapter($fullBook);
        return $bookAuthorToJsonAdapter->mapToJson();
    }

    public function updateBookAuthor(){
        $updateAuthorRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateBookAuthorFromJsonAdapter());
        $book = $this->bookAuthorService->updateBookAuthor($updateAuthorRequest);
        return $book->id;
    }
}