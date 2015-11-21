<?php

class BookExtrasWizardStepResource extends BaseController
{
    /** @var  BookService */
    private $bookService;
    /** @var  BookExtrasService $bookExtrasService */
    private $bookExtrasService;
    /** @var  JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    public function __construct()
    {
        $this->bookExtrasService = App::make('BookExtrasService');
        $this->bookService = App::make('BookService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getBookExtras($id){
        $fullBook = $this->bookService->getFullBook($id, array('publication_date', 'publisher_serie', 'serie'));
        if($fullBook == null){
            throw new ServiceException("Book with id not found");
        }
        $bookExtrasToJsonAdapter = new BookExtrasToJsonAdapter($fullBook);
        return $bookExtrasToJsonAdapter->mapToJson();
    }

    public function updateBookExtras(){
        $updateExtrasRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateBookExtrasFromJsonAdapter());
        $book = $this->bookExtrasService->updateBookExtras($updateExtrasRequest);
        return $book->id;
    }
}