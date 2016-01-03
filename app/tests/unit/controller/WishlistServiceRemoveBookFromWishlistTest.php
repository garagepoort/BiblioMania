<?php

class WishlistServiceRemoveBookFromWishlistTest extends TestCase
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
        $this->wishlistRepository = $this->mock('WishlistRepository');
        $this->wishlistItem = $this->mockEloquent('WishlistItem');
        $this->user = $this->mockEloquent('User');
        $this->book = $this->mockEloquent('Book');

        $this->userRepository->shouldReceive('find')->with(self::USER_ID)->andReturn($this->user)->byDefault();
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn($this->book)->byDefault();
        $this->wishlistRepository->shouldReceive('findByUserAndBook')->with(self::USER_ID, $this->bookIdRequest->getBookId())->andReturn($this->wishlistItem)->byDefault();

        $this->wishlistService = App::make('WishlistService');
    }

    public function test_shouldRemoveCorrectly(){
        $this->wishlistRepository->shouldReceive('delete')->once()->with($this->wishlistItem);

        $this->wishlistService->removeBookFromWishlist(self::USER_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Object user can not be null.
     */
    public function test_shouldThrowExceptionWhenUserDoesNotExist(){
        $this->userRepository->shouldReceive('find')->with(self::USER_ID)->andReturn(null);

        $this->wishlistService->removeBookFromWishlist(self::USER_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Object book can not be null.
     */
    public function test_shouldThrowExceptionWhenBookDoesNotExist(){
        $this->bookRepository->shouldReceive('find')->with($this->bookIdRequest->getBookId())->andReturn(null);

        $this->wishlistService->removeBookFromWishlist(self::USER_ID, $this->bookIdRequest);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage This user does not have the given book on his wishlist. Can not remove book.
     */
    public function test_shouldThrowExceptionWhenBookIsNotInToWishlist(){
        $this->wishlistRepository->shouldReceive('findByUserAndBook')->with(self::USER_ID, $this->bookIdRequest->getBookId())->andReturn(null);

        $this->wishlistService->removeBookFromWishlist(self::USER_ID, $this->bookIdRequest);
    }
}