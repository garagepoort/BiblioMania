<?php

class OeuvreServiceLinkBookToOeuvreItemTest extends TestCase
{
    const OEUVRE_ID = 123;

    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  OeuvreItemLinkValidator */
    private $oeuvreItemLinkValidator;
    /** @var  BookFromAuthor */
    private $oeuvreItem;
    /** @var  Book */
    private $book;
    /** @var  BookIdRequestTestImpl */
    private $bookIdRequest;

    /** @var  OeuvreService */
    private $oeuvreService;

    public function setUp()
    {
        parent::setUp();
        $this->bookIdRequest = new BookIdRequestTestImpl();

        $this->oeuvreItemLinkValidator = $this->mock('OeuvreItemLinkValidator');
        $this->bookFromAuthorRepository = $this->mock('BookFromAuthorRepository');
        $this->bookRepository = $this->mock('BookRepository');

        $this->oeuvreItem = $this->mockEloquent('BookFromAuthor');
        $this->book = $this->mockEloquent('Book');

        $this->bookFromAuthorRepository->shouldReceive('find')->with(self::OEUVRE_ID)->andReturn($this->oeuvreItem)->byDefault();
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId(), array('authors'))->andReturn($this->book)->byDefault();

        $this->oeuvreService = App::make('OeuvreService');
    }

    public function test_shouldLinkCorrectly(){
        $this->oeuvreItemLinkValidator->shouldReceive('validate')->with($this->oeuvreItem, $this->book)->once();
        $this->bookFromAuthorRepository->shouldReceive('linkBookToOeuvreItem')->with(self::OEUVRE_ID, $this->book)->once();

        $this->oeuvreService->linkBookToOeuvreItem(self::OEUVRE_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Object oeuvre item can not be null.
     */
    public function test_shouldThrowExceptionWhenOeuvreItemNotFound(){
        $this->bookFromAuthorRepository->shouldReceive('find')->with(self::OEUVRE_ID)->andReturn(null);

        $this->oeuvreService->linkBookToOeuvreItem(self::OEUVRE_ID, $this->bookIdRequest);
    }


    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Object book can not be null.
     */
    public function test_shouldThrowExceptionWhenBookNotFound(){
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId(), array('authors'))->andReturn(null);

        $this->oeuvreService->linkBookToOeuvreItem(self::OEUVRE_ID, $this->bookIdRequest);
    }
}