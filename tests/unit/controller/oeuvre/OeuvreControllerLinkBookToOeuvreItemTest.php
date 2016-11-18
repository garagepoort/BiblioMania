<?php

namespace tests\unit\controller;

use BookIdRequest;
use Mockery;
use OeuvreService;
use PermissionService;
use TestCase;
use User;

class OeuvreControllerLinkBookToOeuvreItemTest extends TestCase
{
    const USER_ID = 1;
    const OEUVRE_ITEM_ID = 123;
    const BOOK_ID = 321;

    /** @var OeuvreService $oeuvreService */
    private $oeuvreService;
    /** @var PermissionService $permissionService */
    private $permissionService;

    public function setUp(){
        parent::setUp();
        $this->oeuvreService = $this->mock('OeuvreService');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'LINK_OEUVRE_ITEM')->andReturn(false);

        $response = $this->action('POST', 'OeuvreController@linkBookToOeuvreItem', array("id" => self::OEUVRE_ITEM_ID), array());

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_shouldCallJsonMappingAndService(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'LINK_OEUVRE_ITEM')->andReturn(true);
        $postData = array(
            'bookId' => self::BOOK_ID
        );

        $this->oeuvreService->shouldReceive('linkBookToOeuvreItem')->once()->with(self::OEUVRE_ITEM_ID, Mockery::on(function(BookIdRequest $bookIdRequest){
            $this->assertEquals(self::BOOK_ID, $bookIdRequest->getBookId());
            return true;
        }));

        $this->action('POST', 'OeuvreController@linkBookToOeuvreItem', array("id" => self::OEUVRE_ITEM_ID), $postData);

        $this->assertResponseOk();
    }

}