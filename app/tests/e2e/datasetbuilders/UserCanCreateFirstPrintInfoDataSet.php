<?php

namespace e2e\datasetbuilders;

use AuthorService;
use BookService;
use Illuminate\Support\Facades\App;
use UserService;

class UserCanCreateFirstPrintInfoDataSet implements DataSet
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

        return ['authorId' => $this->createAuthor(), 'bookId' => $bookId];
    }

    function getId()
    {
        return 'user.can.create.first.print.info';
    }

    function createUser(){
        $user = $this->userService->createUser('testUser', 'test@test.be', 'test');
        return $user->id;
    }

    function createAuthor()
    {
        $author = new AuthorBuilder();
        $author
            ->withName('first', 'in', 'last')
            ->withDateOfBirth(1, 1, 1992)
            ->withDateOfDeath(1, 1, 2016);
        return $this->authorService->create($author)->id;
    }

    function createBook($userId, $authorId)
    {
        $book = new BookBuilder();
        $book->withTitle('title')
            ->withCountry("België")
            ->withLanguage("Nederlands")
            ->withPublisher("Uitgever")
            ->withPublicationDate(1,1,2011)
            ->withGenre("YA")
            ->withIsbn("1234567890123")
            ->withPages(12)
            ->withPreferredAuthorId($authorId)
            ->withRetailPrice(new PriceBuilder(123, 'EUR'));

        return $this->bookService->create($userId, $book)->id;
    }
}