<?php

/**
 * Created by PhpStorm.
 * User: davidmaes
 * Date: 22/08/15
 * Time: 03:04
 */
class OeuvreController extends Controller
{

    /** @var  OeuvreToParameterMapper */
    private $oeuvreToParameterMapper;
    /** @var  OeuvreService */
    private $oeuvreService;
    /** @var  BookFromAuthorService */
    private $bookFromAuthorService;
    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  BookService */
    private $bookService;
    /** @var  JsonMappingService */
    private $jsonMappingService;

    function __construct()
    {
        $this->oeuvreService = App::make('OeuvreService');
        $this->oeuvreToParameterMapper = App::make('OeuvreToParameterMapper');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
        $this->bookFromAuthorRepository = App::make('BookFromAuthorRepository');
        $this->bookRepository = App::make('BookRepository');
        $this->bookService = App::make('BookService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }

    public function getOeuvreFromAuthor($id){
        $oeuvre = $this->bookFromAuthorRepository->getFromAuthor($id);
        if($oeuvre == null){
            throw new ServiceException('Oeuvre from author not found');
        }
        return array_map(function($item){
            $oeuvreItemToJsonAdapter = new OeuvreItemToJsonAdapter($item);
            return $oeuvreItemToJsonAdapter->mapToJson();
        }, $oeuvre->all());
    }

    public function deleteOeuvreItem($id){
        $this->oeuvreService->deleteOeuvreItem($id);
    }

    public function updateOeuvreItem($id){
        $this->oeuvreService->updateOeuvreItem($id, $this->jsonMappingService->mapInputToJson(Input::get(), new UpdateOeuvreItemFromJsonAdapter()));
    }

    public function getOeuvreByBook($id){
        /** @var Book $book */
        $book = $this->bookRepository->find($id);
        if($book == null){
            throw new ServiceException('Book not found');
        }
        return $this->getOeuvreFromAuthor($book->preferredAuthor()->id);
    }

    public function saveOeuvreItemsToAuthor(){
        $createRequests = $this->jsonMappingService->mapInputArrayToJson(Input::get(), new CreateOeuvreItemFromJsonAdapter());
        foreach($createRequests as $createRequest){
            $this->oeuvreService->saveOeuvreItem($createRequest);
        }
    }

    public function saveBookFromAuthors()
    {
        $authorId = Input::get('author_id');
        $oeuvre = Input::get('oeuvre');

        $this->oeuvreService->saveBookFromAuthors($this->oeuvreToParameterMapper->mapToOeuvreList($oeuvre), $authorId);
        return Response::make(200);
    }

    public function editBookFromAuthors()
    {
        $authorId = Input::get('author_id');
        $oeuvre = Input::get('oeuvre');
        $this->oeuvreService->editBookFromAuthors($this->oeuvreToParameterMapper->mapToOeuvreListWithId($oeuvre), $authorId);
        return Response::make(200);
    }

    public function updateBookFromAuthorPublicationYear()
    {
        $id = Input::get('pk');
        $value = Input::get('value');
        $this->bookFromAuthorService->updateYear($id, $value);
    }

    public function linkBookToBookFromAuthor()
    {
        $book_id = Input::get('book_id');
        $book_from_author_id = Input::get('book_from_author_id');
        $this->oeuvreService->linkBookToBookFromAuthor($book_id, $book_from_author_id);
    }

}