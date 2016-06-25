<?php

namespace tests\unit\controller;

use Mockery;
use PublisherSerieService;
use TestCase;
use User;

class PublisherSerieControllerDeleteSerieTest extends TestCase
{
    const USER_ID = 1;
    const SERIE_ID = 123;

    /** @var  PublisherSerieService */
    private $publisherSerieService;

    public function setUp()
    {
        parent::setUp();
        $this->publisherSerieService = $this->mock('PublisherSerieService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_shouldCallService(){
        $this->publisherSerieService->shouldReceive('deleteSerie')->once()->with(self::SERIE_ID);

        $this->action('DELETE', 'PublisherSerieController@deleteSerie', array('id' => self::SERIE_ID));

        $this->assertResponseOk();
    }
}