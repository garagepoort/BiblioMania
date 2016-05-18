<?php

class BookControllerUnlinkAuthorFromBookTest extends TestCase
{
    const USER_ID = 1;
    const BOOK_ID = 123;
    const AUTHOR_ID = 321;

    /** @var  BookService */
    private $bookService;

    public function setUp()
    {
        parent::setUp();
        $this->bookService = $this->mock('BookService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID));
        $this->be($user);
    }

    public function test_shouldCallJsonMappingAndService(){
        $postData = array(
            'authorId' => self::AUTHOR_ID
        );

        $this->bookService->shouldReceive('unlinkAuthorFromBook')->once()->with(self::BOOK_ID, Mockery::on(function(UnlinkAuthorFromBookRequest $unlinkAuthorFromBookRequest){
            $this->assertEquals(self::AUTHOR_ID, $unlinkAuthorFromBookRequest->getAuthorId());
            return true;
        }));

        $this->action('PUT', 'BookController@unlinkAuthorFromBook', array('id' => self::BOOK_ID), $postData);

        $this->assertResponseOk();
    }
}