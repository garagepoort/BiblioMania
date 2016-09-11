<?php

class BookSerieServiceDeleteSerieTest extends TestCase
{
    const SERIE_ID = 123;
    /** @var  BookSerieService */
    private $bookSerieService;

    /** @var  BookSerieRepository $bookSerieRepository*/
    private $bookSerieRepository;

    /** @var Serie */
    private $serie;
    /** @var  Book */
    private $book;
    /** @var  \Illuminate\Database\Eloquent\Collection */
    private $books;

    public function setUp()
    {
        parent::setUp();
        $this->bookIdRequest = new BookIdRequestTestImpl();
        $this->bookSerieRepository = $this->mock('BookSerieRepository');

        $this->serie = $this->mockEloquent('Serie');
        $this->book = $this->mockEloquent('Book');
        $this->books = $this->mockEloquentCollection();

        $this->serie->shouldReceive('getAttribute')->with("id")->andReturn(self::SERIE_ID);
        $this->serie->shouldReceive('getAttribute')->with("books")->andReturn($this->books);

        $this->bookSerieService = App::make('BookSerieService');
    }

    public function test_addsCorrectly(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn($this->serie);
        $this->bookSerieRepository->shouldReceive('delete')->with($this->serie)->once();
        $this->books->shouldReceive('all')->andReturn(array());

        $this->bookSerieService->deleteSerie(self::SERIE_ID);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie does not exist
     */
    public function test_shouldThrowExceptionWhenSerieToDeleteDoesNotExist(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn(null);

        $this->bookSerieService->deleteSerie(self::SERIE_ID);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie can not be deleted when it is not empty
     */
    public function test_shouldThrowExceptionWhenSerieHasOneOrMoreBooks(){
        $this->bookSerieRepository->shouldReceive('find')->with(self::SERIE_ID)->andReturn($this->serie);
        $this->bookSerieRepository->shouldReceive('delete')->with($this->serie)->never();
        $this->books->shouldReceive('all')->andReturn(array($this->book));

        $this->bookSerieService->deleteSerie(self::SERIE_ID);
    }

}
