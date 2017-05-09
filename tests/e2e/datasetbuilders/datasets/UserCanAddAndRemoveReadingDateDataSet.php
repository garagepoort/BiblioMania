<?php

namespace e2e\datasetbuilders;

use AuthorService;
use BookService;
use Illuminate\Support\Facades\App;
use PersonalBookInfoService;
use UserService;

class UserCanAddAndRemoveReadingDateDataSet implements DataSet
{

    /** @var  AuthorService $authorService */
    private $authorService;
    /** @var  BookService $bookService */
    private $bookService;
    /** @var UserService $userService */
    private $userService;
    /** @var PersonalBookInfoService $personalBookInfoService */
    private $personalBookInfoService;

    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->personalBookInfoService = App::make('PersonalBookInfoService');
        $this->bookService = App::make('BookService');
        $this->userService = App::make('UserService');
    }

    public function run()
    {
        $userId = $this->createUser();
        $author1 = $this->createAuthor('author1_first', 'author1_last');
        $bookId = $this->createBook($userId, $author1->id);
        $this->createPersonalBookInfo($userId, $bookId);

        return ['bookId' => $bookId];
    }

    function getId()
    {
        return 'user.can.add.and.remove.reading.date';
    }

    function createUser(){
        $user = $this->userService->createActiveUser(CreateUserRequestBuilder::buildDefault());
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

    function createPersonalBookInfo($userId, $bookId){
        $personalBookInfo = PersonalBookInfoBuilder::newPersonalBookInfo()
            ->withBookId($bookId)
            ->withInCollection(false)
            ->withReasonNotInCollection('some reason');
        $this->personalBookInfoService->createPersonalBookInfo($userId, $personalBookInfo);
    }
}