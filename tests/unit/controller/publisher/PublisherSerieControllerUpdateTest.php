<?php

namespace tests\unit\controller;

use Mockery;
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

    public function setUp()
    {
        parent::setUp();
        $this->publisherSerieService = $this->mock('PublisherSerieService');
        $this->publisherSerie = $this->mockEloquent('PublisherSerie');

        $this->publisherSerie->shouldReceive('getAttribute')->with('id')->andReturn(self::PUBLISHER_SERIE_ID);

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_shouldCallJsonMappingAndService(){
        $data = array(
            'id' => self::SERIE_ID,
            'name' => self::NAME
        );

        $this->publisherSerieService->shouldReceive('update')->once()->with(Mockery::on(function(UpdateSerieRequest $updateSerieRequest){
            $this->assertEquals(self::SERIE_ID, $updateSerieRequest->getId());
            $this->assertEquals(self::NAME, $updateSerieRequest->getName());
            return true;
        }))->andReturn($this->publisherSerie);

        $response = $this->action('PUT', 'PublisherSerieController@updateSerie', array(), $data);

        $this->assertResponseOk();
    }
}