<?php

namespace e2e\datasetbuilders;

use AuthorService;
use BookService;
use FirstPrintInfoService;
use FirstPrintInfoToJsonAdapter;
use Illuminate\Support\Facades\App;
use UserService;

class UserCanLinkExistingFirstPrintInfoToBookDataSet implements DataSet
{

    /** @var  AuthorService $authorService */
    private $authorService;

    /** @var  BookService $bookService */
    private $bookService;
    /** @var UserService $userService */
    private $userService;
    /** @var FirstPrintInfoService $firstPrintInfoService */
    private $firstPrintInfoService;


    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->bookService = App::make('BookService');
        $this->userService = App::make('UserService');
        $this->firstPrintInfoService = App::make('FirstPrintInfoService');
    }

    public function run()
    {
        $userId = $this->createUser();
        $authorId = $this->createAuthor();
        $bookId = $this->createBook($userId, $authorId);

        $firstPrintInfoToJsonAdapter = new FirstPrintInfoToJsonAdapter($this->createFirstPrintInfo($userId));
        return ['authorId' => $authorId, 'bookId' => $bookId, 'firstPrintInfo' => $firstPrintInfoToJsonAdapter->mapToJson()];
    }

    function getId()
    {
        return 'user.can.link.existing.first.print.info.to.book';
    }

    function createUser(){
        $user = $this->userService->createUser(CreateUserRequestBuilder::buildDefault());
        return $user->id;
    }

    function createAuthor()
    {
        $author = AuthorBuilder::buildDefault();
        return $this->authorService->create($author)->id;
    }

    function createFirstPrintInfo($userId){
        $firstPrintInfoRequest = FirstPrintInfoBuilder::buildDefault();
        return $this->firstPrintInfoService->createFirstPrintInfo($userId, $firstPrintInfoRequest);
    }

    function createBook($userId, $authorId)
    {
        $book = BookBuilder::buildDefault($authorId);
        return $this->bookService->create($userId, $book)->id;
    }
}