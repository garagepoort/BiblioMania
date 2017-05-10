<?php

namespace e2e\datasetbuilders;

use AuthorService;
use BookService;
use Illuminate\Support\Facades\App;
use UserService;

class UserCanCreatePersonalBookInfoDataSet implements DataSet
{

    /** @var  AuthorService $authorService */
    private $authorService;

    /** @var  BookService $bookService */
    private $bookService;
    /** @var UserService $userService */
    private $userService;


    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->bookService = App::make('BookService');
        $this->userService = App::make('UserService');
    }

    public function run()
    {
        $userId = $this->createUser();
        $authorId = $this->createAuthor();
        $bookId = $this->createBook($userId, $authorId);
        $secondBookId = $this->createBook($userId, $authorId);
        $thirdBookId = $this->createBook($userId, $authorId);

        return ['authorId' => $authorId, 'bookId' => $bookId, 'secondBookId' => $secondBookId, 'thirdBookId' => $thirdBookId];
    }

    function getId()
    {
        return 'user.can.create.personal.book.info';
    }

    function createUser(){
        $user = $this->userService->createActiveUser(CreateUserRequestBuilder::buildDefault());
        return $user->id;
    }

    function createAuthor()
    {
        $author = AuthorBuilder::buildDefault();
        return $this->authorService->create($author)->id;
    }

    function createBook($userId, $authorId)
    {
        $book = BookBuilder::buildDefault($authorId);
        return $this->bookService->create($userId, $book)->id;
    }
}