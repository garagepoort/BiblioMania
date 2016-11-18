<?php

namespace tests\unit\controller;

use BookService;
use LinkAuthorToBookRequest;
use Mockery;
use PermissionService;
use TestCase;
use User;

class BookControllerLinkAuthorToBookTest extends TestCase
{
    const USER_ID = 1;
    const BOOK_ID = 123;
    const AUTHOR_ID = 321;

    /** @var  BookService */
    private $bookService;
    /** @var  PermissionService */
    private $permissionService;

    public function setUp()
    {
        parent::setUp();
        $this->bookService = $this->mock('BookService');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'validated' => true, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'LINK_AUTHOR')->andReturn(false);

        $response = $this->action('PUT', 'BookController@linkAuthorToBook', array('id' => self::BOOK_ID), array());

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_shouldCallJsonMappingAndService(){
        $postData = array(
            'authorId' => self::AUTHOR_ID
        );

        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'LINK_AUTHOR')->andReturn(true);
        $this->bookService->shouldReceive('linkAuthorToBook')->once()->with(self::BOOK_ID, Mockery::on(function(LinkAuthorToBookRequest $linkAuthorToBookRequest){
            $this->assertEquals(self::AUTHOR_ID, $linkAuthorToBookRequest->getAuthorId());
            return true;
        }));

        $this->action('PUT', 'BookController@linkAuthorToBook', array('id' => self::BOOK_ID), $postData);

        $this->assertResponseOk();
    }
}