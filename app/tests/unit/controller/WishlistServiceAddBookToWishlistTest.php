<?php

class WishlistServiceAddBookToWishlistTest extends TestCase
{
    const USER_ID = 123;

    /** @var  WishlistService */
    private $wishlistService;
    /** @var  WishlistRepository */
    private $wishlistRepository;
    /** @var  UserRepository */
    private $userRepository;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  BookElasticIndexer */
    private $bookElasticIndexer;


    /** @var  WishlistItem */
    private $wishlistItem;
    /** @var  User */
    private $user;
    /** @var  Book */
    private $book;
    /** @var  BookIdRequestTestImpl */
    private $bookIdRequest;

    public function setUp()
    {
        parent::setUp();
        $this->bookIdRequest = new BookIdRequestTestImpl();
        $this->userRepository = $this->mock('UserRepository');
        $this->bookRepository = $this->mock('BookRepository');
        $this->bookElasticIndexer = $this->mock('BookElasticIndexer');
        $this->wishlistRepository = $this->mock('WishlistRepository');

            $this->wishlistItem = $this->mockEloquent('WishlistItem');
        $this->user = $this->mockEloquent('User');
        $this->book = $this->mockEloquent('Book');


        $this->userRepository->shouldReceive('find')->with(self::USER_ID)->andReturn($this->user)->byDefault();
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn($this->book)->byDefault();
        $this->wishlistRepository->shouldReceive('findByUserAndBook')->with(self::USER_ID, $this->bookIdRequest->getBookId())->andReturn(null)->byDefault();

        $this->wishlistService = App::make('WishlistService');
    }

    public function test_shouldAddCorrectly(){
        $this->bookElasticIndexer->shouldReceive('indexBook')->once()->with(Mockery::any());
        $this->wishlistRepository->shouldReceive('save')->with(Mockery::on(function($wishlistItem){
            $this->assertEquals(self::USER_ID, $wishlistItem->user_id);
            $this->assertEquals($this->bookIdRequest->getBookId(), $wishlistItem->book_id);
            return true;
        }))->once();

        $this->wishlistService->addBookToWishlist(self::USER_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object user can not be null.
     */
    public function test_shouldThrowExceptionWhenUserDoesNotExist(){
        $this->userRepository->shouldReceive('find')->with(self::USER_ID)->andReturn(null);

        $this->wishlistService->addBookToWishlist(self::USER_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object book can not be null.
     */
    public function test_shouldThrowExceptionWhenBookDoesNotExist(){
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn(null);

        $this->wishlistService->addBookToWishlist(self::USER_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage This wishlist already contains this book. Can not add.
     */
    public function test_shouldThrowExceptionWhenBookIsAlreadyAddedToWishlist(){
        $this->wishlistRepository->shouldReceive('findByUserAndBook')->with(self::USER_ID, $this->bookIdRequest->getBookId())->andReturn($this->wishlistItem);

        $this->wishlistService->addBookToWishlist(self::USER_ID, $this->bookIdRequest);
    }
}