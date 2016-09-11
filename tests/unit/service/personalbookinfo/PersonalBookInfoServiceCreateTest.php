<?php

class PersonalBookInfoServiceCreateTest extends TestCase
{
    const USER_ID = 1;
    const BOOK_ID = 321;
    const REASON_NOT_IN_COLLECTION = "reasonNotInCollection";

    /** @var PersonalBookInfoService $personalBookInfoService */
    private $personalBookInfoService;
    /** @var PersonalBookInfoRepository $personalBookInfoRepository */
    private $personalBookInfoRepository;
    /** @var BookRepository $bookRepository */
    private $bookRepository;
    /** @var GiftInfoService $giftInfoService */
    private $giftInfoService;
    /** @var BuyInfoService $buyInfoService */
    private $buyInfoService;
    /** @var BookElasticIndexer $bookElasticIndexer */
    private $bookElasticIndexer;
    /** @var WishlistRepository $wishlistRepository */
    private $wishlistRepository;

    /** @var CreatePersonalBookInfoRequestTestImpl $createPersonalBookInfoRequestTestImpl */
    private $createPersonalBookInfoRequestTestImpl;

    /** @var Book $book */
    private $book;
    /** @var WishlistItem $wishlistItem */
    private $wishlistItem;
    /** @var FirstPrintInfo $firstPrintInfo */
    private $firstPrintInfo;

    public function setUp(){
        parent::setUp();
        $this->createPersonalBookInfoRequestTestImpl = new CreatePersonalBookInfoRequestTestImpl();
        $this->createPersonalBookInfoRequestTestImpl->setBookId(self::BOOK_ID);

        $this->personalBookInfoRepository = $this->mock('PersonalBookInfoRepository');
        $this->wishlistRepository = $this->mock('WishlistRepository');
        $this->bookRepository = $this->mock('BookRepository');
        $this->buyInfoService = $this->mock('BuyInfoService');
        $this->giftInfoService = $this->mock('GiftInfoService');
        $this->bookElasticIndexer = $this->mock('BookElasticIndexer');

        $this->book = $this->mockEloquent('Book');
        $this->firstPrintInfo = $this->mockEloquent('FirstPrintInfo');
        $this->wishlistItem = $this->mockEloquent('WishlistItem');

        $this->bookRepository->shouldReceive('find')->with(self::BOOK_ID)->andReturn($this->book)->byDefault();
        $this->personalBookInfoRepository->shouldReceive('findByUserAndBook')->with(self::USER_ID, self::BOOK_ID)->andReturn(null)->byDefault();
        $this->wishlistRepository->shouldReceive('findByUserAndBook')->with(self::USER_ID, self::BOOK_ID)->andReturn(null)->byDefault();

        $this->personalBookInfoService = App::make('PersonalBookInfoService');
    }
    
    public function test_createsCorrectWhenNotInCollection(){
        $this->createPersonalBookInfoRequestTestImpl->setInCollection(false);
        $this->createPersonalBookInfoRequestTestImpl->setReasonNotInCollection(self::REASON_NOT_IN_COLLECTION);

        $this->buyInfoService->shouldReceive('delete')->once();
        $this->giftInfoService->shouldReceive('delete')->once();
        $this->bookElasticIndexer->shouldReceive('indexBookById')->once()->with(self::BOOK_ID);

        $this->personalBookInfoRepository->shouldReceive('save')->once()->with(Mockery::on(function(PersonalBookInfo $personalBookInfo){
            $this->assertEquals($personalBookInfo->book_id, self::BOOK_ID);
            $this->assertEquals($personalBookInfo->owned, false);
            $this->assertEquals($personalBookInfo->reason_not_owned, self::REASON_NOT_IN_COLLECTION);
            return true;
        }));

        $this->personalBookInfoService->createPersonalBookInfo(self::USER_ID, $this->createPersonalBookInfoRequestTestImpl);
    }
    
    public function test_createsCorrectlyWithBuyInfo(){
        $buyInfo = new BuyInfoRequestTestImpl();
        $this->createPersonalBookInfoRequestTestImpl->setInCollection(true);
        $this->createPersonalBookInfoRequestTestImpl->setBuyInfo($buyInfo);

        $this->giftInfoService->shouldReceive('delete')->once();
        $this->buyInfoService->shouldReceive('createOrUpdate')->once()->with(Mockery::any(), $buyInfo);
        $this->bookElasticIndexer->shouldReceive('indexBookById')->once()->with(self::BOOK_ID);

        $this->personalBookInfoRepository->shouldReceive('save')->once()->with(Mockery::on(function(PersonalBookInfo $personalBookInfo){
            $this->assertEquals($personalBookInfo->book_id, self::BOOK_ID);
            $this->assertEquals($personalBookInfo->owned, true);
            return true;
        }));

        $this->personalBookInfoService->createPersonalBookInfo(self::USER_ID, $this->createPersonalBookInfoRequestTestImpl);
    }


    public function test_createsCorrectlyWithGiftInfo(){
        $giftInfo = new GiftInfoRequestTestImpl();
        $this->createPersonalBookInfoRequestTestImpl->setInCollection(true);
        $this->createPersonalBookInfoRequestTestImpl->setGiftInfo($giftInfo);

        $this->buyInfoService->shouldReceive('delete')->once();
        $this->giftInfoService->shouldReceive('createOrUpdate')->once()->with(Mockery::any(), $giftInfo);
        $this->bookElasticIndexer->shouldReceive('indexBookById')->once()->with(self::BOOK_ID);

        $this->personalBookInfoRepository->shouldReceive('save')->once()->with(Mockery::on(function(PersonalBookInfo $personalBookInfo){
            $this->assertEquals($personalBookInfo->book_id, self::BOOK_ID);
            $this->assertEquals($personalBookInfo->owned, true);
            return true;
        }));

        $this->personalBookInfoService->createPersonalBookInfo(self::USER_ID, $this->createPersonalBookInfoRequestTestImpl);
    }

    public function test_removesFromWishlistAfterCreation(){
        $this->wishlistRepository->shouldReceive('findByUserAndBook')->with(self::USER_ID, self::BOOK_ID)->andReturn($this->wishlistItem);
        $this->wishlistRepository->shouldReceive('delete')->once()->with($this->wishlistItem);

        $this->personalBookInfoService->createPersonalBookInfo(self::USER_ID, $this->createPersonalBookInfoRequestTestImpl);
    }
    
     /**
      * @expectedException \Bendani\PhpCommon\Utils\Exception\ServiceException
      * @expectedExceptionMessage Object book can not be null.
      */
    public function test_throwsExceptionWhenBookNotFound(){
        $this->bookRepository->shouldReceive('find')->once()->with(self::BOOK_ID)->andReturn(null);

        $this->personalBookInfoService->createPersonalBookInfo(self::USER_ID, $this->createPersonalBookInfoRequestTestImpl);
    }


    /**
     * @expectedException \Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage The book given already has a personal book information. Cannot create a new one.
     */
    public function test_throwsExceptionWhenUserHasAlreadyPersonalBookInfoForThisBook(){

        $this->personalBookInfoRepository->shouldReceive('findByUserAndBook')->with(self::USER_ID, self::BOOK_ID)->andReturn($this->firstPrintInfo)->byDefault();

        $this->personalBookInfoService->createPersonalBookInfo(self::USER_ID, $this->createPersonalBookInfoRequestTestImpl);
    }

     /**
      * @expectedException \Bendani\PhpCommon\Utils\Exception\ServiceException
      * @expectedExceptionMessage Buy or gift information is not given
      */
    public function test_throwsExceptionWhenInCollectionAndNoBuyOrGiftInfo(){
        $this->createPersonalBookInfoRequestTestImpl->setInCollection(true);

        $this->personalBookInfoService->createPersonalBookInfo(self::USER_ID, $this->createPersonalBookInfoRequestTestImpl);
    }

     /**
      * @expectedException \Bendani\PhpCommon\Utils\Exception\ServiceException
      * @expectedExceptionMessage Both buy and gift information are given. Only one can be chosen
      */
    public function test_throwsExceptionWhenInCollectionAndBothBuyAndGiftInfo(){
        $this->createPersonalBookInfoRequestTestImpl->setInCollection(true);
        $this->createPersonalBookInfoRequestTestImpl->setBuyInfo(new BuyInfoRequestTestImpl());
        $this->createPersonalBookInfoRequestTestImpl->setGiftInfo(new GiftInfoRequestTestImpl());

        $this->personalBookInfoService->createPersonalBookInfo(self::USER_ID, $this->createPersonalBookInfoRequestTestImpl);
    }


}