<?php

class OeuvreServiceLinkBookToOeuvreItemTest extends TestCase
{
    const OEUVRE_ID = 123;

    /** @var  OeuvreItemRepository */
    private $oeuvreItemRepository;
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
    /** @var  BookElasticIndexer */
    private $bookElasticIndexer;

    /** @var  OeuvreService */
    private $oeuvreService;

    public function setUp()
    {
        parent::setUp();
        $this->bookIdRequest = new BookIdRequestTestImpl();

        $this->oeuvreItemLinkValidator = $this->mock('OeuvreItemLinkValidator');
        $this->oeuvreItemRepository = $this->mock('OeuvreItemRepository');
        $this->bookRepository = $this->mock('BookRepository');
        $this->bookElasticIndexer = $this->mock('BookElasticIndexer');

        $this->oeuvreItem = $this->mockEloquent('BookFromAuthor');
        $this->book = $this->mockEloquent('Book');

        $this->oeuvreItemRepository->shouldReceive('find')->with(self::OEUVRE_ID)->andReturn($this->oeuvreItem)->byDefault();
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId(), array('authors', 'book_from_authors'))->andReturn($this->book)->byDefault();

        $this->oeuvreService = App::make('OeuvreService');
    }

    public function test_shouldLinkCorrectly(){
        $this->oeuvreItemLinkValidator->shouldReceive('validate')->with($this->oeuvreItem, $this->book)->once();
        $this->oeuvreItemRepository->shouldReceive('linkBookToOeuvreItem')->with(self::OEUVRE_ID, $this->book)->once();
        $this->bookElasticIndexer->shouldReceive('indexBook')->once()->with($this->book);

        $this->oeuvreService->linkBookToOeuvreItem(self::OEUVRE_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object oeuvre item can not be null.
     */
    public function test_shouldThrowExceptionWhenOeuvreItemNotFound(){
        $this->oeuvreItemRepository->shouldReceive('find')->with(self::OEUVRE_ID)->andReturn(null);

        $this->oeuvreService->linkBookToOeuvreItem(self::OEUVRE_ID, $this->bookIdRequest);
    }


    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object book can not be null.
     */
    public function test_shouldThrowExceptionWhenBookNotFound(){
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId(), array('authors', 'book_from_authors'))->andReturn(null);

        $this->oeuvreService->linkBookToOeuvreItem(self::OEUVRE_ID, $this->bookIdRequest);
    }
}