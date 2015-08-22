<?php

class OeuvreServiceLinkBookToBookFromAuthorTest extends TestCase
{
    const BOOK_ID = 12;
    const BOOK_FROM_AUTHOR_ID = 321;

    /** @var  OeuvreService */
    private $oeuvreService;

    /** @var  BookRepository */
    private $bookRepository;
    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;

    /** @var  Book */
    private $book;
    /** @var  BookFromAuthor */
    private $bookFromAuthor;

    public function setUp()
    {
        parent::setUp();
        $this->bookRepository = $this->mock('BookRepository');
        $this->bookFromAuthorRepository = $this->mock('BookFromAuthorRepository');

        $this->oeuvreService = App::make('OeuvreService');

        $this->book = $this->mockEloquent('Book');
        $this->bookFromAuthor = $this->mockEloquent('BookFromAuthor');
    }

    public function test_throwsErrorIfBookNotFound()
    {
        $this->bookFromAuthorRepository->shouldReceive('find')
            ->with(self::BOOK_FROM_AUTHOR_ID, array('author'))
            ->andReturn($this->bookFromAuthor);

        $this->bookRepository->shouldReceive('find')
            ->with(self::BOOK_ID, array('authors'))
            ->andReturn(null);
        try {
            $this->oeuvreService->linkBookToBookFromAuthor(self::BOOK_ID, self::BOOK_FROM_AUTHOR_ID);
            $this->fail('Should throw exception book is null');
        } catch (ServiceException $e) {
            $this->assertEquals($e->getMessage(), "Book not found");
        }
    }

    public function test_throwsErrorIfBookFromAuthorNotFound()
    {
        $this->bookFromAuthorRepository->shouldReceive('find')
            ->with(self::BOOK_FROM_AUTHOR_ID, array('author'))
            ->andReturn(null);

        $this->bookRepository->shouldReceive('find')
            ->with(self::BOOK_ID, array('authors'))
            ->andReturn($this->book);

        try {
            $this->oeuvreService->linkBookToBookFromAuthor(self::BOOK_ID, self::BOOK_FROM_AUTHOR_ID);
            $this->fail('Should throw exception book is null');
        } catch (ServiceException $e) {
            $this->assertEquals($e->getMessage(), "BookFromAuthor not found");
        }
    }

    public function test_throwsErrorIfBookAndBookFromAuthorDoNotHaveSameAuthor()
    {
        $bookFromAuthorAuthor = new Author();
        $bookFromAuthorAuthor->id = 321;

        $this->bookFromAuthor->author = $bookFromAuthorAuthor;
        $this->bookFromAuthorRepository->shouldReceive('find')
            ->with(self::BOOK_FROM_AUTHOR_ID, array('author'))
            ->andReturn($this->createFakeBookFromAuthor($bookFromAuthorAuthor));

        $this->bookRepository->shouldReceive('find')
            ->with(self::BOOK_ID, array('authors'))
            ->andReturn($this->createFakeBook());

        try {
            $this->oeuvreService->linkBookToBookFromAuthor(self::BOOK_ID, self::BOOK_FROM_AUTHOR_ID);
            $this->fail('Should throw exception book is null');
        } catch (ServiceException $e) {
            $this->assertEquals($e->getMessage(), "Author is not the same for book and oeuvreItem");
        }
    }

    public function test_throwsLinksBookToBookFromAuthor()
    {
        $book = $this->createFakeBook();
        $bookFromAuthorAuthor = new Author();
        $bookFromAuthorAuthor->id = 123;

        $bookFromAuthor = $this->createFakeBookFromAuthor($bookFromAuthorAuthor);
        $this->bookFromAuthorRepository->shouldReceive('find')
            ->with(self::BOOK_FROM_AUTHOR_ID, array('author'))
            ->andReturn($bookFromAuthor);

        $this->bookRepository->shouldReceive('find')
            ->with(self::BOOK_ID, array('authors'))
            ->andReturn($book);

        $this->bookRepository->shouldReceive('setBookFromAuthor')
            ->with($book, $bookFromAuthor)
            ->once();

        $this->oeuvreService->linkBookToBookFromAuthor(self::BOOK_ID, self::BOOK_FROM_AUTHOR_ID);
    }
}
