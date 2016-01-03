<?php

class WishlistServiceGetWishlistForUserTest extends TestCase
{
    const USER_ID = 123;

    /** @var  WishlistService */
    private $wishlistService;
    /** @var  WishlistRepository */
    private $wishlistRepository;

    /** @var  WishlistItem */
    private $wishlistItem1;
    /** @var  WishlistItem */
    private $wishlistItem2;
    /** @var  WishlistItem */
    private $wishlistItem3;

    public function setUp()
    {
        parent::setUp();
        $this->wishlistRepository = $this->mock('WishlistRepository');
        $this->wishlistItem1 = $this->mockEloquent('WishlistItem');
        $this->wishlistItem2 = $this->mockEloquent('WishlistItem');
        $this->wishlistItem3 = $this->mockEloquent('WishlistItem');

        $this->wishlistService = App::make('WishlistService');
    }

    public function test_shouldCallRepository(){
        $collection = $this->mockEloquentCollection();
        $wishlist = array(
                $this->wishlistItem1,
                $this->wishlistItem2,
                $this->wishlistItem3
            );
        $collection->shouldReceive('all')->andReturn($wishlist);

        $this->wishlistRepository->shouldReceive('getWishListForUser')->with(self::USER_ID)->once()->andReturn($collection);

        $result = $this->wishlistService->getWishlistForUser(self::USER_ID);

        $this->assertEquals($result, $wishlist);
    }
}