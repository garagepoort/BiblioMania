<?php

namespace tests\unit\controller;

use Book;
use BookFromAuthor;
use OeuvreService;
use PermissionService;
use TestCase;
use User;

class OeuvreControllerGetOeuvreItemTest extends TestCase
{
    const USER_ID = 1;
    const BOOK_ID = 43;
    const OEUVRE_ITEM_ID = 123;

    const TITLE = 'title';
    const PUBLICATION_YEAR = 1992;
    const AUTHOR_ID = 132;

    /** @var OeuvreService $oeuvreService */
    private $oeuvreService;
    /** @var PermissionService $permissionService */
    private $permissionService;
    /** @var BookFromAuthor $oeuvreItem */
    private $oeuvreItem;
    /** @var Book $book */
    private $book;

    private $books;

    public function setUp(){
        parent::setUp();
        $this->book = $this->mockEloquent('Book');
        $this->book->shouldReceive('getAttribute')->with('id')->andReturn(self::BOOK_ID);

        $this->books = $this->mockEloquentCollection();
        $this->books->shouldReceive('all')->andReturn(array($this->book));

        $this->oeuvreItem = $this->mockEloquent('BookFromAuthor');
        $this->oeuvreItem->shouldReceive('getAttribute')->with('id')->andReturn(self::OEUVRE_ITEM_ID);
        $this->oeuvreItem->shouldReceive('getAttribute')->with('title')->andReturn(self::TITLE);
        $this->oeuvreItem->shouldReceive('getAttribute')->with('publication_year')->andReturn(self::PUBLICATION_YEAR);
        $this->oeuvreItem->shouldReceive('getAttribute')->with('books')->andReturn($this->books);
        $this->oeuvreItem->shouldReceive('getAttribute')->with('author_id')->andReturn(self::AUTHOR_ID);

        $this->oeuvreService = $this->mock('OeuvreService');
        $this->permissionService = $this->mock('PermissionService');

        $user = new User(array('username' => 'John', 'id' => self::USER_ID, 'activated' => true));
        $this->be($user);
    }

    public function test_shouldFailsIfUserDoesNotHaveCorrectPermission(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'READ_OEUVRE_ITEM')->andReturn(false);

        $response = $this->action('GET', 'OeuvreController@getOeuvreItem', array("id" => self::OEUVRE_ITEM_ID));

        $this->assertResponseStatus(403);
        $this->assertEquals($response->getContent(), "{\"code\":403,\"message\":\"user.does.not.have.right.permissions\"}");
    }

    public function test_shouldCallJsonMappingAndService(){
        $this->permissionService->shouldReceive('hasUserPermission')->once()->with(self::USER_ID, 'READ_OEUVRE_ITEM')->andReturn(true);
        $this->oeuvreService->shouldReceive('find')->once()->with(self::OEUVRE_ITEM_ID)->andReturn($this->oeuvreItem);

        $response = $this->action('GET', 'OeuvreController@getOeuvreItem', array("id" => self::OEUVRE_ITEM_ID));

        $this->assertResponseOk();
        $this->assertEquals($response->original['id'], self::OEUVRE_ITEM_ID);
        $this->assertEquals($response->original['title'], self::TITLE);
        $this->assertEquals($response->original['publicationYear'], self::PUBLICATION_YEAR);
        $this->assertEquals($response->original['authorId'], self::AUTHOR_ID);
        $this->assertEquals($response->original['state'], 'LINKED');
        $this->assertEquals($response->original['linkedBooks'][0], self::BOOK_ID);
    }

}