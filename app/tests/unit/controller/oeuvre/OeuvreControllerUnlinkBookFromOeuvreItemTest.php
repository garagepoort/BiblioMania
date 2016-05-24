<?php

namespace tests\unit\controller;

use BookIdRequest;
use Mockery;
use OeuvreService;
use TestCase;
use User;

class OeuvreControllerUnlinkBookFromOeuvreItemTest extends TestCase
{
    const USER_ID = 1;
    const OEUVRE_ITEM_ID = 123;
    const BOOK_ID = 321;

    /** @var OeuvreService $oeuvreService */
    private $oeuvreService;

    public function setUp(){
        parent::setUp();
        $this->oeuvreService = $this->mock('OeuvreService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_shouldCallJsonMappingAndService(){
        $postData = array(
            'bookId' => self::BOOK_ID
        );

        $this->oeuvreService->shouldReceive('deleteLinkedBookFromOeuvreItem')->once()->with(self::OEUVRE_ITEM_ID, Mockery::on(function(BookIdRequest $bookIdRequest){
            $this->assertEquals(self::BOOK_ID, $bookIdRequest->getBookId());
            return true;
        }));

        $this->action('PUT', 'OeuvreController@deleteBookFromOeuvreItem', array("id" => self::OEUVRE_ITEM_ID), $postData);

        $this->assertResponseOk();
    }

}