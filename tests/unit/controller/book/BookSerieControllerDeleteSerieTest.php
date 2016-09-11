<?php

namespace tests\unit\controller;

use BookSerieService;
use Mockery;
use PublisherSerieService;
use TestCase;
use User;

class BookSerieControllerDeleteSerieTest extends TestCase
{
    const USER_ID = 1;
    const SERIE_ID = 123;

    /** @var  BookSerieService */
    private $bookSerieService;

    public function setUp()
    {
        parent::setUp();
        $this->bookSerieService = $this->mock('BookSerieService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_shouldCallService(){
        $this->bookSerieService->shouldReceive('deleteSerie')->once()->with(self::SERIE_ID);

        $this->action('DELETE', 'SerieController@deleteSerie', array('id' => self::SERIE_ID));

        $this->assertResponseOk();
    }
}