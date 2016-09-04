<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class BookSerieServiceremoveBookFromSerieTest extends TestCase
{
    const SERIE_ID = 123;
    /** @var  BookSerieService */
    private $bookSerieService;

    /** @var  BookSerieRepository $bookSerieRepository*/
    private $bookSerieRepository;
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
        $this->bookSerieRepository = $this->mock('BookSerieRepository');
        $this->bookRepository = $this->mock('BookRepository');

        $this->serie = $this->mockEloquent('Serie');
        $this->serie->shouldReceive('getAttribute')->with("id")->andReturn(self::SERIE_ID);

        $this->book = $this->mockEloquent('Book');
        $this->book->shouldReceive('getAttribute')->with("id")->andReturn($this->bookIdRequest->getBookId())->byDefault();
        $this->book->shouldReceive('getAttribute')->with("serie_id")->andReturn(self::SERIE_ID)->byDefault();

        $this->bookSerieService = App::make('BookSerieService');
    }



    public function test_removesCorrectly(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn($this->serie);
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn($this->book);

        $this->book->shouldReceive('setAttribute')->once()->with("serie_id", null);
        $this->bookRepository->shouldReceive('save')->once()->with($this->book);

        $this->bookSerieService->removeBookFromSerie(self::SERIE_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie does not exist
     */
    public function test_shouldThrowExceptionWhenSerieToUpdateDoesNotExists(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn(null);

        $this->bookSerieService->removeBookFromSerie(self::SERIE_ID, $this->bookIdRequest);
    }


    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Book does not exist
     */
    public function test_shouldThrowExceptionWhenBookDoesNotExists(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn($this->serie);
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn(null);

        $this->bookSerieService->removeBookFromSerie(self::SERIE_ID, $this->bookIdRequest);
    }


    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Trying to remove book from serie but book is not a part of the given serie
     */
    public function test_shouldThrowExceptionWhenBookIsNotInSeriegGiven(){
        $this->book->shouldReceive('getAttribute')->with("serie_id")->andReturn(12333224);

        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn($this->serie);
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn($this->book);

        $this->bookSerieService->removeBookFromSerie(self::SERIE_ID, $this->bookIdRequest);
    }
}
