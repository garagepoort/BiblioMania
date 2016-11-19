<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class BookSerieServiceAddBookToSerieTest extends TestCase
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
        $this->book->shouldReceive('getAttribute')->with("id")->andReturn($this->bookIdRequest->getBookId());

        $this->bookSerieService = App::make('BookSerieService');
    }



    public function test_addsCorrectly(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn($this->serie);
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn($this->book);

        $this->book->shouldReceive('setAttribute')->with("serie_id", $this->bookIdRequest->getBookId())->once();
        $this->bookRepository->shouldReceive('save')->with($this->book);

        $this->bookSerieService->addBookToSerie(self::SERIE_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie does not exist
     */
    public function test_shouldThrowExceptionWhenSerieToUpdateDoesNotExists(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn(null);

        $this->bookSerieService->addBookToSerie(self::SERIE_ID, $this->bookIdRequest);
    }


    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Book does not exist
     */
    public function test_shouldThrowExceptionWhenBookDoesNotExists(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn($this->serie);
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn(null);

        $this->bookSerieService->addBookToSerie(self::SERIE_ID, $this->bookIdRequest);
    }

}
