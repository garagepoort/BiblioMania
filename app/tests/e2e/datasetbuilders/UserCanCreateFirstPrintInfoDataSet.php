<?php

namespace e2e\datasetbuilders;

use AuthorService;
use BookService;
use Illuminate\Support\Facades\App;

class UserCanCreateFirstPrintInfoDataSet implements DataSet
{

    /** @var  AuthorService $authorService */
    private $authorService;

    /** @var  BookService $bookService */
    private $bookService;

    public function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->bookService = App::make('BookService');
    }

    public function run()
    {
        $authorId = $this->createAuthor();
        $bookId = $this->createBook($authorId);

        return ['authorId' => $this->createAuthor(), 'bookId' => $bookId];
    }

    function getId()
    {
        return 'user.can.create.first.print.info';
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

    function createBook($authorId)
    {
        $book = new BookBuilder();
        $book
            ->withTitle('title')
            ->withCountry("België")
            ->withLanguage("Nederlands")
            ->withPublisher("Uitgever")
            ->withPublicationDate(1,1,2011)
            ->withGenre("YA")
            ->withIsbn("1234567890123")
            ->withPages(12)
            ->withPreferredAuthorId($authorId);
        return $this->bookService->create($book)->id;
    }
}