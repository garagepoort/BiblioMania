<?php

class OeuvreControllerLinkBookToBookFromAuthorTest extends TestCase
{
    const BOOK_ID = 122;
    const BOOK_FROM_AUTHOR_ID = 32331;

    /** @var  OeuvreService */
    private $oeuvreService;

    public function setUp(){
        parent::setUp();
        $this->oeuvreService = $this->mock('OeuvreService');
    }

    public function test_delegatsCorrectly(){
        $this->oeuvreService->shouldReceive("linkBookToBookFromAuthor")
            ->with(self::BOOK_ID, self::BOOK_FROM_AUTHOR_ID)
            ->once();

        $parameters = array(
            'book_id'=> self::BOOK_ID,
            "book_from_author_id"=> self::BOOK_FROM_AUTHOR_ID);

        $this->action('POST', 'OeuvreController@linkBookToBookFromAuthor', null, $parameters);
    }
}
