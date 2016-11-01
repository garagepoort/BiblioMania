<?php

namespace tests\unit\controller;

use Mockery;
use PublisherService;
use TestCase;
use User;

class PublisherControllerDeletePublisherTest extends TestCase
{
    const USER_ID = 1;
    const PUBLISHER_ID = 123;

    /** @var  PublisherService */
    private $publisherService;

    public function setUp()
    {
        parent::setUp();
        $this->publisherService = $this->mock('PublisherService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_shouldCallService(){
        $this->publisherService->shouldReceive('deletePublisher')->once()->with(self::PUBLISHER_ID);

        $this->action('DELETE', 'PublisherController@deletePublisher', array('id' => self::PUBLISHER_ID));

        $this->assertResponseOk();
    }
}