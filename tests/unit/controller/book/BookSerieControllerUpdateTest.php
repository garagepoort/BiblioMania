<?php

namespace tests\unit\controller;

use BookSerieService;
use Mockery;
use PermissionService;
use TestCase;
use UpdateSerieRequest;
use User;

class BookSerieControllerUpdateTest extends TestCase
{
    const SERIE_ID = 21312;
    const NAME = 'een serie';
    const USER_ID = 123;

    /** @var  BookSerieService */
    private $bookSerieService;
    /** @var PermissionService $permissionService */
    private $permissionService;

    public function setUp()
    {
        parent::setUp();
        $this->bookSerieService = $this->mock('BookSerieService');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'UPDATE_SERIE')->andReturn(false);

        $response = $this->action('PUT', 'SerieController@updateSerie', array(), array());

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_shouldCallJsonMappingAndService(){
        $this->permissionService->shouldReceive('hasUserPermission')->with(self::USER_ID, 'UPDATE_SERIE')->andReturn(true);
        $data = array(
            'id' => self::SERIE_ID,
            'name' => self::NAME
        );

        $this->bookSerieService->shouldReceive('update')->once()->with(Mockery::on(function(UpdateSerieRequest $updateSerieRequest){
            $this->assertEquals(self::SERIE_ID, $updateSerieRequest->getId());
            $this->assertEquals(self::NAME, $updateSerieRequest->getName());
            return true;
        }));

        $response = $this->action('PUT', 'SerieController@updateSerie', array(), $data);

        $this->assertResponseOk();
    }
}