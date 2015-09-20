<?php

class AuthorControllerGetAuthorTest extends TestCase
{
    /** @var AuthorService $authorService */
    private $authorService;
    /** @var Author $author */
    private $author;
    /** @var Book $book*/
    private $book;


    public function setUp(){
        parent::setUp();
        $this->authorService = $this->mock('AuthorService');
        $this->book = $this->createFakeBook();
        $this->author = $this->book->preferredAuthor();
    }

    public function testShouldCreateViewWithCorrectData(){
        $parameters = array(
            'id'=>'1'
        );

        $this->authorService->shouldReceive('find')->once()->andReturn($this->author);

        $response = $this->action('GET', 'AuthorController@getAuthor', null, $parameters);

        $this->assertViewHas('title', 'Auteur');
        $this->assertViewHas('author', $this->author);
        $this->assertViewHas('author_json', json_encode($this->author));
        $this->assertViewHas('oeuvre_json', json_encode($this->author->oeuvre));
    }
}
