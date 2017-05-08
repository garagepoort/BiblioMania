<?php

namespace e2e\datasetbuilders;

use AuthorService;
use BookSerieService;
use BookService;
use e2e\datasetbuilders\builders\BookIdBuilder;
use Illuminate\Support\Facades\App;
use Serie;
use UserService;

class UserCanRemoveBookSerieDataSet implements DataSet
{

    /** @var  AuthorService $authorService */
    private $authorService;
    /** @var  BookService $bookService */
    private $bookService;
    /** @var UserService $userService */
    private $userService;
    /** @var BookSerieService $bookSerieService */
    private $bookSerieService;


    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->bookService = App::make('BookService');
        $this->userService = App::make('UserService');
        $this->bookSerieService = App::make('BookSerieService');
    }

    public function run()
    {
        $userId = $this->createUser();
        $author1 = $this->createAuthor('author1_first', 'author1_last');
        $bookId = $this->createBook($userId, $author1->id);
        $serie1Id = $this->createSerie('serie1')->id;
        $serie2Id = $this->createSerie('serie2')->id;

        $this->bookSerieService->addBookToSerie($serie1Id, BookIdBuilder::aBookIdRequest()->withBookId($bookId));

        return ['bookId' => $bookId, 'serie1Id'=> $serie1Id, 'serie2Id' => $serie2Id];
    }

    function getId()
    {
        return 'user.can.remove.book.serie';
    }

    function createUser(){
        $user = $this->userService->createUser(CreateUserRequestBuilder::buildDefault());
        return $user->id;
    }

    function createAuthor($firstname, $lastname)
    {
        $author = AuthorBuilder::buildDefault();
        $author->withName($firstname, 'infix', $lastname);
        return $this->authorService->create($author);
    }

    function createBook($userId, $authorId)
    {
        $book = BookBuilder::buildDefault($authorId);
        return $this->bookService->create($userId, $book)->id;
    }

    /**
     * @param $serieName
     * @return Serie
     */
    function createSerie($serieName){
        return $this->bookSerieService->findOrSave($serieName);
    }
}