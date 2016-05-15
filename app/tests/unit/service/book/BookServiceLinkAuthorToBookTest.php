<?php

class BookServiceLinkAuthorToBookTest extends TestCase {
    const BOOK_ID = 123;
    const AUTHOR_ID = 321;

    /** @var  BookService */
    private $bookService;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var AuthorRepository $authorRepository */
    private $authorRepository;
    /** @var Book $book */
    private $book;
    /** @var Author $author */
    private $author;
    /** @var LinkAuthorFromBookRequestTestImpl $linkAuthorToBookRequestTestImpl */
    private $linkAuthorToBookRequestTestImpl;


    private $WITH_ARRAY = array();

    public function setUp(){
        parent::setUp();
        $this->linkAuthorToBookRequestTestImpl = new LinkAuthorFromBookRequestTestImpl();
        $this->linkAuthorToBookRequestTestImpl->setAuthorId(self::AUTHOR_ID);

        $this->bookRepository = $this->mock('BookRepository');
        $this->authorRepository = $this->mock('AuthorRepository');

        $this->book = new Book();
        $this->book->authors = array();

        $this->author = $this->mockEloquent('Author');

        $this->bookService = App::make('BookService');

        $this->bookRepository->shouldReceive('find')->with(self::BOOK_ID, $this->WITH_ARRAY)->andReturn($this->book)->byDefault();
        $this->authorRepository->shouldReceive('find')->with(self::AUTHOR_ID)->andReturn($this->author)->byDefault();
        $this->authorRepository->shouldReceive('findByBook')->with($this->book, self::AUTHOR_ID)->andReturn(null)->byDefault();
    }

    public function test_linksCorrectly(){
        $this->bookRepository->shouldReceive('addAuthorToBook')->with($this->book, self::AUTHOR_ID)->once();

        $this->bookService->linkAuthorToBook(self::BOOK_ID, $this->linkAuthorToBookRequestTestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Author is already linked to book
     */
    public function test_throwsExceptionWhenLinkingAlreadyLinkedAuthor(){
        $this->authorRepository->shouldReceive('findByBook')->once()->with($this->book, self::AUTHOR_ID)->andReturn($this->author);

        $this->bookService->linkAuthorToBook(self::BOOK_ID, $this->linkAuthorToBookRequestTestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object book can not be null.
     */
    public function test_throwsExceptionWhenBookNotFound(){
        $this->bookRepository->shouldReceive('find')->once()->with(self::BOOK_ID, $this->WITH_ARRAY)->andReturn(null);

        $this->bookService->linkAuthorToBook(self::BOOK_ID, $this->linkAuthorToBookRequestTestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object author can not be null.
     */
    public function test_throwsExceptionWhenAuthorNotFound(){
        $this->authorRepository->shouldReceive('find')->once()->with(self::AUTHOR_ID)->andReturn(null)->byDefault();

        $this->bookService->linkAuthorToBook(self::BOOK_ID, $this->linkAuthorToBookRequestTestImpl);
    }

}
