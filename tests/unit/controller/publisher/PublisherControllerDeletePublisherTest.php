<?php

namespace tests\unit\controller;

use Mockery;
use PermissionService;
use PublisherService;
use TestCase;
use User;

class PublisherControllerDeletePublisherTest extends TestCase
{
    const USER_ID = 1;
    const PUBLISHER_ID = 123;

    /** @var  PublisherService */
    private $publisherService;
    /** @var PermissionService $permissionService */
    private $permissionService;


    public function setUp()
    {
        parent::setUp();
        $this->publisherService = $this->mock('PublisherService');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'DELETE_PUBLISHER')->andReturn(false);

        $response = $this->action('DELETE', 'PublisherController@deletePublisher', array('id' => self::PUBLISHER_ID));

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_shouldCallService(){
        $this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'DELETE_PUBLISHER')->andReturn(true);
        $this->publisherService->shouldReceive('deletePublisher')->once()->with(self::PUBLISHER_ID);

        $this->action('DELETE', 'PublisherController@deletePublisher', array('id' => self::PUBLISHER_ID));

        $this->assertResponseOk();
    }
}