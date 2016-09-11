<?php

class FirstPrintInfoServiceLinkBookTest extends TestCase
{
    const FIRST_PRINT_INFO_ID = 123;

    /** @var FirstPrintInfoService $firstPrintInfoService */
    private $firstPrintInfoService;
    /** @var  FirstPrintInfoRepository */
    private $firstPrintInfoRepository;
    /** @var BookRepository $bookRepository */
    private $bookRepository;
    /** @var LinkBookToFirstPrintInfoRequestTestImpl $linkBookToFirstPrintInfoRequestTestImpl */
    private $linkBookToFirstPrintInfoRequestTestImpl;

    /** @var Book $book */
    private $book;
    /** @var FirstPrintInfo $firstPrintInfo */
    private $firstPrintInfo;

    public function setUp(){
        parent::setUp();
        $this->linkBookToFirstPrintInfoRequestTestImpl = new LinkBookToFirstPrintInfoRequestTestImpl();

        $this->firstPrintInfoRepository = $this->mock('FirstPrintInfoRepository');
        $this->bookRepository = $this->mock('BookRepository');
        $this->book = $this->mockEloquent('Book');
        $this->firstPrintInfo = $this->mockEloquent('FirstPrintInfo');

        $this->firstPrintInfoService = App::make('FirstPrintInfoService');
    }
    
    public function test_linksCorrectly(){
        $this->firstPrintInfoRepository->shouldReceive('find')->once()->with(self::FIRST_PRINT_INFO_ID)->andReturn($this->firstPrintInfo);
        $this->bookRepository->shouldReceive('find')->once()->with($this->linkBookToFirstPrintInfoRequestTestImpl->getBookId())->andReturn($this->book);
        $this->bookRepository->shouldReceive('save')->once()->with($this->book);
        $this->book->shouldReceive('setAttribute')->with(self::FIRST_PRINT_INFO_ID);

        $this->firstPrintInfoService->linkBook(self::FIRST_PRINT_INFO_ID, $this->linkBookToFirstPrintInfoRequestTestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object first print info to link can not be null.
     */
    public function test_throwsExceptionWhenFirstPrintInfoNotFound(){
        $this->firstPrintInfoRepository->shouldReceive('find')->once()->with(self::FIRST_PRINT_INFO_ID)->andReturn(null);
        $this->bookRepository->shouldReceive('find')->never();
        $this->bookRepository->shouldReceive('save')->never();

        $this->firstPrintInfoService->linkBook(self::FIRST_PRINT_INFO_ID, $this->linkBookToFirstPrintInfoRequestTestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object book to link can not be null.
     */
    public function test_throwsExceptionWhenBookToLinkToNotFound(){
        $this->firstPrintInfoRepository->shouldReceive('find')->once()->with(self::FIRST_PRINT_INFO_ID)->andReturn($this->firstPrintInfo);
        $this->bookRepository->shouldReceive('find')->once()->with($this->linkBookToFirstPrintInfoRequestTestImpl->getBookId())->andReturn(null);
        $this->bookRepository->shouldReceive('save')->never();

        $this->firstPrintInfoService->linkBook(self::FIRST_PRINT_INFO_ID, $this->linkBookToFirstPrintInfoRequestTestImpl);
    }


}