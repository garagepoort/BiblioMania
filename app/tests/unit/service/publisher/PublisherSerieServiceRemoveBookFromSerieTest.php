<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class PublisherSerieServiceRemoveBookFromSerieTest extends TestCase
{
    const PUBLISHER_SERIE_ID = 123;
    /** @var  PublisherSerieService */
    private $publisherSerieService;

    /** @var  PublisherSerieRepository $publisherSerieRepository*/
    private $publisherSerieRepository;
    /** @var  BookRepository $bookRepository*/
    private $bookRepository;

    /** @var  BookIdRequest */
    private $bookIdRequest;

    /** @var  Serie */
    private $serie;
    /** @var  Book */
    private $book;

    public function setUp()
    {
        parent::setUp();
        $this->bookIdRequest = new BookIdRequestTestImpl();
        $this->publisherSerieRepository = $this->mock('PublisherSerieRepository');
        $this->bookRepository = $this->mock('BookRepository');

        $this->serie = $this->mockEloquent('PublisherSerie');
        $this->serie->shouldReceive('getAttribute')->with("id")->andReturn(self::PUBLISHER_SERIE_ID);

        $this->book = $this->mockEloquent('Book');
        $this->book->shouldReceive('getAttribute')->with("id")->andReturn($this->bookIdRequest->getBookId())->byDefault();
        $this->book->shouldReceive('getAttribute')->with("publisher_serie_id")->andReturn(self::PUBLISHER_SERIE_ID)->byDefault();

        $this->publisherSerieService = App::make('PublisherSerieService');
    }



    public function test_removesCorrectly(){
        $this->publisherSerieRepository->shouldReceive('find')->with(self::PUBLISHER_SERIE_ID)->andReturn($this->serie);
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn($this->book);

        $this->book->shouldReceive('setAttribute')->once()->with("publisher_serie_id", null);
        $this->bookRepository->shouldReceive('save')->once()->with($this->book);

        $this->publisherSerieService->removeBookFromSerie(self::PUBLISHER_SERIE_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie does not exist
     */
    public function test_shouldThrowExceptionWhenSerieToUpdateDoesNotExists(){
        $this->publisherSerieRepository->shouldReceive('find')->with(self::PUBLISHER_SERIE_ID)->andReturn(null);

        $this->publisherSerieService->removeBookFromSerie(self::PUBLISHER_SERIE_ID, $this->bookIdRequest);
    }


    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Book does not exist
     */
    public function test_shouldThrowExceptionWhenBookDoesNotExists(){
        $this->publisherSerieRepository->shouldReceive('find')->with(self::PUBLISHER_SERIE_ID)->andReturn($this->serie);
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn(null);

        $this->publisherSerieService->removeBookFromSerie(self::PUBLISHER_SERIE_ID, $this->bookIdRequest);
    }


    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Trying to remove book from serie but book is not a part of the given serie
     */
    public function test_shouldThrowExceptionWhenBookIsNotInSeriegGiven(){
        $this->book->shouldReceive('getAttribute')->with("serie_id")->andReturn(12333224);

        $this->publisherSerieRepository->shouldReceive('find')->with(self::PUBLISHER_SERIE_ID)->andReturn($this->serie);
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn($this->book);

        $this->publisherSerieService->removeBookFromSerie(self::PUBLISHER_SERIE_ID, $this->bookIdRequest);
    }
}
