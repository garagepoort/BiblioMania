<?php

class BookServiceUnlinkAuthorFromBookTest extends TestCase {
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
    /** @var UnlinkAuthorFromBookRequestTestImpl $unlinkAuthorFromBookRequestTestImpl */
    private $unlinkAuthorFromBookRequestTestImpl;
    /** @var PreferredAuthorPivot $preferredAuthorPivot */
    private $preferredAuthorPivot;

    private $WITH_ARRAY = array();

    public function setUp(){
        parent::setUp();
        $this->preferredAuthorPivot = new PreferredAuthorPivot();
        $this->preferredAuthorPivot->preferred = false;

        $this->unlinkAuthorFromBookRequestTestImpl = new UnlinkAuthorFromBookRequestTestImpl();
        $this->unlinkAuthorFromBookRequestTestImpl->setAuthorId(self::AUTHOR_ID);

        $this->bookRepository = $this->mock('BookRepository');
        $this->authorRepository = $this->mock('AuthorRepository');

        $this->book = new Book();
        $this->book->authors = array();

        $this->author = $this->mockEloquent('Author');
        $this->author->shouldReceive('getAttribute')->with('pivot')->andReturn($this->preferredAuthorPivot);

        $this->bookService = App::make('BookService');

        $this->bookRepository->shouldReceive('find')->with(self::BOOK_ID, $this->WITH_ARRAY)->andReturn($this->book)->byDefault();
        $this->authorRepository->shouldReceive('find')->with(self::AUTHOR_ID)->andReturn($this->author)->byDefault();
    }

//    public function test_unlinksCorrectly(){
//        $this->bookRepository->shouldReceive('removeAuthorFromBook')->with($this->book, self::AUTHOR_ID)->once();
//
//        $this->bookService->unlinkAuthorFromBook(self::BOOK_ID, $this->unlinkAuthorFromBookRequestTestImpl);
//    }
//
//    /**
//     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
//     * @expectedExceptionMessage Preferred author cannot be unlinked from book.
//     */
//    public function test_throwsExceptionWhenUnlinkingPreferredAuthor(){
//        $this->preferredAuthorPivot->preferred = true;
//
//        $this->bookService->unlinkAuthorFromBook(self::BOOK_ID, $this->unlinkAuthorFromBookRequestTestImpl);
//    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object book can not be null.
     */
    public function test_throwsExceptionWhenBookNotFound(){
        $this->bookRepository->shouldReceive('find')->once()->with(self::BOOK_ID, $this->WITH_ARRAY)->andReturn(null);

        $this->bookService->unlinkAuthorFromBook(self::BOOK_ID, $this->unlinkAuthorFromBookRequestTestImpl);
    }

//    /**
//     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
//     * @expectedExceptionMessage Object author can not be null.
//     */
//    public function test_throwsExceptionWhenAuthorNotFound(){
//        $this->authorRepository->shouldReceive('find')->once()->with(self::AUTHOR_ID)->andReturn(null)->byDefault();
//
//        $this->bookService->unlinkAuthorFromBook(self::BOOK_ID, $this->unlinkAuthorFromBookRequestTestImpl);
//    }

}
