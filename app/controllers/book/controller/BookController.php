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
        $filteredBooksResult = $this->bookService->filterBooks($filters);

        return $this->mapBooksToJson($filteredBooksResult);
    }

    public function search()
    {
        $filters = Input::all();
        if (!is_array($filters)) {
            $filters = array();
        }
        Session::put('book.filters', $filters);

        $filteredBooksResult = $this->bookService->filterBooks($filters);

        return $this->mapBooksToJson($filteredBooksResult);
    }

    public function searchBooks()
    {
        $query = Input::get('query');
        $operator = Input::get('operator');
        $type = Input::get('type');
        $read = Input::get('read');
        $owned = Input::get('owned');

        $book_id = Input::get('book_id');
        $orderBy = Input::get('order_by');

        $searchValues = new BookSearchValues($query, $operator, $type, $read, $owned);
        /** @var FilteredBooksResult $filteredBooksResult */
        $filteredBooksResult = $this->bookService->searchBooks($book_id, $searchValues, $orderBy);
        return $this->mapBooksToJson($filteredBooksResult);
    }

    /**
     * @param $filteredBooksResult
     * @return array
     */
    public function mapBooksToJson($filteredBooksResult)
    {
        $jsonItems = array_map(function ($item) {

            list($imageHeight, $imageWidth, $bookImage) = $this->bookJsonMapper->getCoverImageFromBook($item);

            /** @var Book $item */
            return array(
                "id" => $item->id,
                "title" => $item->title,
                "subtitle" => $item->subtitle,
                "rating" => $item->personal_book_info->rating,
                "author" => $item->preferredAuthor()->name . " " . $item->preferredAuthor()->firstname,
                "imageHeight" => $imageHeight,
                "imageWidth" => $imageWidth,
                "spritePointer" => $item->spritePointer,
                "coverImage" => $bookImage,
                "useSpriteImage" => $item->useSpriteImage,
                "warnings" => $this->createBookWarnings($item),
                "read" => $item->personal_book_info->read
            );
        }, $filteredBooksResult->getPaginatedItems()->getItems());

        $result = array(
            "total" => $filteredBooksResult->getPaginatedItems()->getTotal(),
            "last_page" => $filteredBooksResult->getPaginatedItems()->getLastPage(),
            "current_page" => $filteredBooksResult->getPaginatedItems()->getCurrentPage(),
            "data" => $jsonItems,
            "library_information" => array(
                "total_amount_books" => $filteredBooksResult->getTotalAmountOfBooks(),
                "total_amount_books_owned" => $filteredBooksResult->getTotalAmountOfBooksOwned(),
                "total_value" => $filteredBooksResult->getTotalValue(),
            )
        );
        return $result;
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