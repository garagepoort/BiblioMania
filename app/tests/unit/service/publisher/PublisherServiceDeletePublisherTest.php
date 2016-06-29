<?php

class PublisherServiceDeletePublisherTest extends TestCase
{
    const PUBLISHER_ID = 123;
    const USER_ID = 123;

    /** @var PublisherService $publisherService */
    private $publisherService;

    /** @var PublisherRepository $publisherRepository */
    private $publisherRepository;
    /** @var Publisher $publisher */
    private $publisher;
    /** @var Book $book */
    private $book;
    /** @var FirstPrintInfo $firstPrintInfo */
    private $firstPrintInfo;

    private $books;
    private $firstPrintInfos;

    public function setUp()
    {
        parent::setUp();

        $this->book = $this->mockEloquent('Book');
        $this->firstPrintInfo = $this->mockEloquent('FirstPrintInfo');
        $this->publisher = $this->mockEloquent('Publisher');

        $this->books = $this->mockEloquentCollection();
        $this->books->shouldReceive('all')->andReturn(array())->byDefault();
        $this->publisher->shouldReceive('getAttribute')->with('books')->andReturn($this->books);

        $this->firstPrintInfos = $this->mockEloquentCollection();
        $this->firstPrintInfos->shouldReceive('all')->andReturn(array())->byDefault();
        $this->publisher->shouldReceive('getAttribute')->with('first_print_infos')->andReturn($this->firstPrintInfos);

        $this->publisherRepository = $this->mock('PublisherRepository');
        $this->publisherService = App::make('PublisherService');

        $this->publisherRepository->shouldReceive('findByUserAndId')->with(self::USER_ID, self::PUBLISHER_ID, array('books', 'first_print_infos'))->andReturn($this->publisher)->byDefault();
    }

    public function test_deletesBook(){
        $this->publisherRepository->shouldReceive('delete')->once()->with($this->publisher);

        $this->publisherService->deletePublisher(self::USER_ID, self::PUBLISHER_ID);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage translation.error.publisher.not.found
     */
    public function test_throwsExceptionWhenPublisherNotFound()
    {
        $this->publisherRepository->shouldReceive('findByUserAndId')->with(self::USER_ID, self::PUBLISHER_ID, array('books', 'first_print_infos'))->andReturn(null);

        $this->publisherService->deletePublisher(self::USER_ID, self::PUBLISHER_ID);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage translation.error.publisher.linked.to.books.can.not.be.deleted
     */
    public function test_throwsExceptionWhenPublisherStillLinkedToBooks()
    {
        $this->books->shouldReceive('all')->andReturn(array($this->book));

        $this->publisherService->deletePublisher(self::USER_ID, self::PUBLISHER_ID);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage translation.error.publisher.linked.to.first.print.infos.can.not.be.deleted
     */
    public function test_throwsExceptionWhenPublisherStillLinkedToFirstPrintInfos()
    {
        $this->firstPrintInfos->shouldReceive('all')->andReturn(array($this->firstPrintInfo));

        $this->publisherService->deletePublisher(self::USER_ID, self::PUBLISHER_ID);
    }

}
