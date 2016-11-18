<?php

namespace tests\unit\controller;

use Mockery;
use PermissionService;
use PublisherSerieService;
use TestCase;
use User;

class PublisherSerieControllerDeleteSerieTest extends TestCase
{
    const USER_ID = 1;
    const SERIE_ID = 123;

    /** @var  PublisherSerieService */
    private $publisherSerieService;
    /** @var PermissionService $permissionService */
    private $permissionService;


    public function setUp()
    {
        parent::setUp();
        $this->publisherSerieService = $this->mock('PublisherSerieService');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'DELETE_SERIE')->andReturn(false);

        $response = $this->action('DELETE', 'PublisherSerieController@deleteSerie', array('id' => self::SERIE_ID));

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_shouldCallService(){
        $this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'DELETE_SERIE')->andReturn(true);
        $this->publisherSerieService->shouldReceive('deleteSerie')->once()->with(self::SERIE_ID);

        $this->action('DELETE', 'PublisherSerieController@deleteSerie', array('id' => self::SERIE_ID));

        $this->assertResponseOk();
    }
}