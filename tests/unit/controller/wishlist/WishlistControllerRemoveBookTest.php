<?php

namespace tests\unit\controller;

use BookIdRequest;
use Mockery;
use PermissionService;
use TestCase;
use User;
use WishlistService;

class WishlistControllerRemoveBookTest extends TestCase
{
    const USER_ID = 1;
    const BOOK_ID = 123;

    /** @var WishlistService $wishlistService */
    private $wishlistService;
    /** @var PermissionService $permissionService */
    private $permissionService;

    public function setUp()
    {
        parent::setUp();
        $this->wishlistService = $this->mock('WishlistService');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'UNLINK_WISHLIST')->andReturn(false);

        $response = $this->action('PUT', 'WishlistController@removeBookFromWishlist', array(), array());

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_shouldCallJsonMappingAndService(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'UNLINK_WISHLIST')->andReturn(true);
        $postData = array(
            'bookId' => self::BOOK_ID
        );

        $this->wishlistService->shouldReceive('removeBookFromWishlist')->once()->with(self::USER_ID, Mockery::on(function(BookIdRequest $bookIdRequest){
            $this->assertEquals(self::BOOK_ID, $bookIdRequest->getBookId());
            return true;
        }));

        $this->action('PUT', 'WishlistController@removeBookFromWishlist', array(), $postData);

        $this->assertResponseOk();
    }
}