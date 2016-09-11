<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class PublisherSerieServiceDeleteSerieTest extends TestCase
{
    const PUBLISHER_SERIE_ID = 123;
    /** @var  PublisherSerieService */
    private $publisherSerieService;

    /** @var  PublisherSerieRepository $publisherSerieRepository*/
    private $publisherSerieRepository;

    /** @var  Serie */
    private $serie;
    /** @var  Book */
    private $book;
    /** @var  \Illuminate\Database\Eloquent\Collection */
    private $books;

    public function setUp()
    {
        parent::setUp();
        $this->bookIdRequest = new BookIdRequestTestImpl();
        $this->publisherSerieRepository = $this->mock('PublisherSerieRepository');

        $this->serie = $this->mockEloquent('PublisherSerie');
        $this->book = $this->mockEloquent('Book');
        $this->books = $this->mockEloquentCollection();

        $this->serie->shouldReceive('getAttribute')->with("id")->andReturn(self::PUBLISHER_SERIE_ID);
        $this->serie->shouldReceive('getAttribute')->with("books")->andReturn($this->books);

        $this->publisherSerieService = App::make('PublisherSerieService');
    }



    public function test_addsCorrectly(){
        $this->publisherSerieRepository->shouldReceive('find')->with(self::PUBLISHER_SERIE_ID)->andReturn($this->serie);
        $this->publisherSerieRepository->shouldReceive('delete')->with($this->serie)->once();
        $this->books->shouldReceive('all')->andReturn(array());

        $this->publisherSerieService->deleteSerie(self::PUBLISHER_SERIE_ID);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie does not exist
     */
    public function test_shouldThrowExceptionWhenSerieToDeleteDoesNotExist(){
        $this->publisherSerieRepository->shouldReceive('find')->with(self::PUBLISHER_SERIE_ID)->andReturn(null);

        $this->publisherSerieService->deleteSerie(self::PUBLISHER_SERIE_ID);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Serie can not be deleted when it is not empty
     */
    public function test_shouldThrowExceptionWhenSerieHasOneOrMoreBooks(){
        $this->publisherSerieRepository->shouldReceive('find')->with(self::PUBLISHER_SERIE_ID)->andReturn($this->serie);
        $this->publisherSerieRepository->shouldReceive('delete')->with($this->serie)->never();
        $this->books->shouldReceive('all')->andReturn(array($this->book));

        $this->publisherSerieService->deleteSerie(self::PUBLISHER_SERIE_ID);
    }

}
