<?php

class OeuvreWizardStepResource extends BaseController
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

    public function getOeuvre($id){
        /** @var Book $fullBook */
        $fullBook = $this->bookService->getFullBook($id, array('publication_date', 'publisher_serie', 'serie'));
        if($fullBook == null){
            throw new ServiceException("Book with id not found");
        }
        $oeuvreToJsonAdapter = new OeuvreToJsonAdapter($fullBook->preferredAuthor());
        return $oeuvreToJsonAdapter->mapToJson();
    }

    public function updateBookAuthor(){
        $updateAuthorRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateBookAuthorFromJsonAdapter());
        $book = $this->bookAuthorService->updateBookAuthor($updateAuthorRequest);
        return $book->id;
    }
}