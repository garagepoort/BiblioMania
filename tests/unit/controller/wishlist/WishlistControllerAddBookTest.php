<?php

namespace tests\unit\controller;

use BookIdRequest;
use Mockery;
use TestCase;
use User;
use WishlistService;

class WishlistControllerAddBookTest extends TestCase
{
    const USER_ID = 1;
    const BOOK_ID = 123;

    /** @var WishlistService $wishlistService */
    private $wishlistService;

    public function setUp()
    {
        parent::setUp();
        $this->wishlistService = $this->mock('WishlistService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_shouldCallJsonMappingAndService(){
        $postData = array(
            'bookId' => self::BOOK_ID
        );

        $this->wishlistService->shouldReceive('addBookToWishlist')->once()->with(self::USER_ID, Mockery::on(function(BookIdRequest $bookIdRequest){
            $this->assertEquals(self::BOOK_ID, $bookIdRequest->getBookId());
            return true;
        }));

        $this->action('POST', 'WishlistController@addBookToWishlist', array(), $postData);

        $this->assertResponseOk();
    }
}