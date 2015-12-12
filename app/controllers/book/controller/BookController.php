<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookController extends BaseController
{
    /** @var  BookService */
    private $bookService;
    /** @var  BookFilterManager */
    private $bookFilterHandler;
    /** @var  JsonMappingService */
    private $jsonMappingService;


    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->bookFilterHandler = App::make('BookFilterManager');
        $this->jsonMappingService = App::make('JsonMappingService');
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
        return $this->bookFilterHandler->getFiltersInJson();
    }

    public function getFullBook($book_id)
    {
        $fullBook = $this->bookService->getFullBook($book_id);
        Ensure::objectNotNull('book', $fullBook);
        $fullBookToJsonAdapter = new FullBookToJsonAdapter($fullBook);
        return $fullBookToJsonAdapter->mapToJson();
    }

    public function filterBooks()
    {
        $filters = Input::get('filter');
        if (!is_array($filters)) {
            $filters = array();
        }
        Session::put('book.filters', $filters);
        $books = $this->bookService->filterBooks($filters);

        return array_map(function($item){
            $bookToJsonAdapter = new BookToJsonAdapter($item);
            return $bookToJsonAdapter->mapToJson();
        }, $books->all());
    }

    public function search()
    {
        $filters = Input::all();
        if (!is_array($filters)) {
            $filters = array();
        }
        Session::put('book.filters', $filters);

        $books = $this->bookService->filterBooks($filters);

        return array_map(function($item){
            $bookToJsonAdapter = new BookToJsonAdapter($item);
            return $bookToJsonAdapter->mapToJson();
        }, $books->all());
    }

    private function createBookWarnings($book)
    {
        $warnings = array();
        $baseUrl = URL::to('/');
        if ($book->read) {
            array_push($warnings, array(
                "id" => "bookread",
                "message" => "Dit boek is gelezen",
                "icon" => $baseUrl . "/images/check-circle-success.png",
                "goToLink" => "/createOrEditBook/step/6/"
            ));
        } else {
            array_push($warnings, array(
                "id" => "bookread",
                "message" => "Dit boek is niet gelezen",
                "icon" => $baseUrl . "/images/check-circle-fail.png",
                "goToLink" => "/createOrEditBook/step/6/"
            ));
        }
        if (!StringUtils::isEmpty($book->old_tags)) {
            array_push($warnings, array(
                "id" => " bookHasOldTags",
                "message" => "Dit boek heeft oude tags",
                "icon" => $baseUrl . "/images/exclamation_mark.png",
                "goToLink" => "/createOrEditBook/step/2/"
            ));
        }
        if ($book->book_from_author_id == null) {
            array_push($warnings, array(
                "id" => "bookIsNotLinkedToOeuvre",
                "message" => "Dit boek is niet gelinked aan een oeuvre",
                "icon" => $baseUrl . "/images/linked_warning.png",
                "goToLink" => "/createOrEditBook/step/4/"
            ));
        }
        return $warnings;
    }
}