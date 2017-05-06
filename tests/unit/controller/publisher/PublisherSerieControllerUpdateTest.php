<?php

namespace tests\unit\controller;

use Mockery;
use PermissionService;
use PublisherSerie;
use PublisherSerieService;
use TestCase;
use UpdateSerieRequest;
use User;

class PublisherSerieControllerUpdateTest extends TestCase
{
    const SERIE_ID = 21312;
    const NAME = 'een serie';
    const USER_ID = 123;
    const PUBLISHER_SERIE_ID = 321;

    /** @var  PublisherSerieService */
    private $publisherSerieService;
    /** @var PublisherSerie $publisherSerie */
    private $publisherSerie;
    /** @var PermissionService $permissionService*/
    private $permissionService;

    public function setUp()
    {
        parent::setUp();
        $this->publisherSerieService = $this->mock('PublisherSerieService');
        $this->publisherSerie = $this->mockEloquent('PublisherSerie');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'UPDATE_SERIE')->andReturn(false);

        $response = $this->action('PUT', 'PublisherSerieController@updateSerie', array(), array());

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_shouldCallJsonMappingAndService(){
        $this->publisherSerie->shouldReceive('getAttribute')->with('id')->andReturn(self::PUBLISHER_SERIE_ID);
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'UPDATE_SERIE')->andReturn(true);

        $data = array(
            'id' => self::SERIE_ID,
            'name' => self::NAME
        );

        $this->publisherSerieService->shouldReceive('update')->once()->with(Mockery::on(function(UpdateSerieRequest $updateSerieRequest){
            $this->assertEquals(self::SERIE_ID, $updateSerieRequest->getId());
            $this->assertEquals(self::NAME, $updateSerieRequest->getName());
            return true;
        }))->andReturn($this->publisherSerie);

        $this->action('PUT', 'PublisherSerieController@updateSerie', array(), $data);

        $this->assertResponseOk();
    }
}