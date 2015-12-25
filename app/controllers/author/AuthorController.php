<?php

class AuthorController extends BaseController
{

    /** @var  AuthorService */
    private $authorService;
    /** @var BookService */
    private $bookService;
    /** @var JsonMappingService */
    private $jsonMappingService;

    function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->bookService = App::make('BookService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function createAuthor(){
        $author = $this->authorService->create($this->jsonMappingService->mapInputToJson(Input::get(), new CreateAuthorFromJsonAdapter()));
        return Response::json(array('success' => true, 'id' => $author->id), 200);
    }

    public function updateAuthor(){
        return $this->authorService->update($this->jsonMappingService->mapInputToJson(Input::get(), new UpdateAuthorFromJsonAdapter()))->id;
    }

    public function getAuthor($id){
        $author = $this->authorService->find($id);
        Ensure::objectNotNull("author", $author);
        $authorToJsonAdapter = new AuthorToJsonAdapter($author);
        return $authorToJsonAdapter->mapToJson();
    }

    public function getAuthorByBook($id){
        /** @var Book $book */
        $book = $this->bookService->find($id, array('authors'));

        Ensure::objectNotNull("book", $book);
        Ensure::objectNotNull("book preferred author", $book->preferredAuthor());

        $authorToJsonAdapter = new AuthorToJsonAdapter($book->preferredAuthor());
        return $authorToJsonAdapter->mapToJson();
    }

    public function getAllAuthors(){
        return array_map(function($item){
            $authorToJsonAdapter = new AuthorForOverviewToJsonAdapter($item);
            return $authorToJsonAdapter->mapToJson();
        }, $this->authorService->getAllAuthors()->all());
    }

    public function getNextAuthors()
    {
        $query = Input::get('query');
        $operator = Input::get('operator');
        $type = Input::get('type');
        $orderBy = Input::get('orderBy');
        return $this->authorService->getFilteredAuthors($query, $operator, $type, $orderBy);
    }
}