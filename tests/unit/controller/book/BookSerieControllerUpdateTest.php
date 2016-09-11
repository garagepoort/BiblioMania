<?php

namespace tests\unit\controller;

use BookSerieService;
use Mockery;
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

    public function setUp()
    {
        parent::setUp();
        $this->bookSerieService = $this->mock('BookSerieService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_shouldCallJsonMappingAndService(){
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