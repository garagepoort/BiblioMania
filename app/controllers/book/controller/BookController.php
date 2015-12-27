<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookController extends BaseController
{
    /** @var  BookService */
    private $bookService;
    /** @var  BookFilterManager */
    private $bookFilterManager;
    /** @var  JsonMappingService */
    private $jsonMappingService;
    /** @var  FilterHistoryService */
    private $filterHistoryService;


    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->bookFilterManager = App::make('BookFilterManager');
        $this->jsonMappingService = App::make('JsonMappingService');
        $this->filterHistoryService = App::make('FilterHistoryService');
    }

    public function getBooks(){
        return array_map(function($item){
            $bookToJsonAdapter = new BookToJsonAdapter($item);
            return $bookToJsonAdapter->mapToJson();
        }, $this->bookService->allBooks()->all());
    }
    public function getBooksFromUser(){
        return array_map(function($item){
            $bookToJsonAdapter = new BookToJsonAdapter($item);
            return $bookToJsonAdapter->mapToJson();
        }, $this->bookService->allBooksFromUser(Auth::user()->id)->all());
    }

    public function getBooksByAuthor($authorId){
        return array_map(function($item){
            $bookToJsonAdapter = new BookToJsonAdapter($item);
            return $bookToJsonAdapter->mapToJson();
        }, $this->bookService->getBooksByAuthor($authorId)->all());
    }

    public function linkAuthorToBook($bookId){
        $linkAuthorRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new LinkAuthorToBookFromJsonAdapter());
        $this->bookService->linkAuthorToBook($bookId, $linkAuthorRequest);
    }

    public function unlinkAuthorFromBook($bookId){
        $unlinkAuthorRequest = $this->jsonMappingService->mapInputToJson(Input::get(), new UnlinkAuthorToBookFromJsonAdapter());
        $this->bookService->unlinkAuthorFromBook($bookId, $unlinkAuthorRequest);
    }

    public function createBook(){
        return $this->bookService->create($this->jsonMappingService->mapInputToJson(Input::get(), new CreateBookFromJsonAdapter()));
    }

    public function updateBook(){
        return $this->bookService->update($this->jsonMappingService->mapInputToJson(Input::get(), new UpdateBookFromJsonAdapter()));
    }

    public function deleteBook()
    {
        $this->bookService->deleteBook(Input::get("bookId"));
    }

    public function getFilters()
    {
        return array_map(function($item){
            $adapter = new FilterToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->bookFilterManager->getFilters());
    }

    public function getMostUsedFilters(){
        return array_map(function($item){
            $adapter = new FilterToJsonAdapter($item);
            return $adapter->mapToJson();
        }, $this->bookFilterManager->getMostUsedFilters());
    }

    public function getFullBook($book_id)
    {
        $fullBook = $this->bookService->getFullBook($book_id);
        Ensure::objectNotNull('book', $fullBook);
        $fullBookToJsonAdapter = new FullBookToJsonAdapter($fullBook);
        return $fullBookToJsonAdapter->mapToJson();
    }

    public function search()
    {
        $filtersInJson = Input::get();
        Ensure::objectIsArray('filters', $filtersInJson);

        $allFiltersFromJsonAdapter = new AllFiltersFromJsonAdapter($filtersInJson);

        $books = $this->bookService->filterBooks($allFiltersFromJsonAdapter->getFilters());

        $result = array();
        foreach($books->all() as $book){
            $bookToJsonAdapter = new BookToJsonAdapter($book);
            array_push($result, $bookToJsonAdapter->mapToJson());
        }
        return $result;
    }
}