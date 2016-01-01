<?php

class AuthorServiceFindTest extends TestCase {
    const AUTHOR_ID = 123;
    /** @var  AuthorService */
    private $authorService;
    /** @var AuthorRepository $authorRepository*/
    private $authorRepository;
    /** @var DateService $dateService*/
    private $dateService;

    /** @var  Author */
    private $author;

    public function setUp(){
        parent::setUp();
        $this->authorRepository = $this->mock("AuthorRepository");
        $this->dateService = $this->mock("DateService");
        $this->author = $this->mockEloquent("Author");

        $this->authorService = App::make('AuthorService');
    }

    public function test_shouldCallRepository(){
        $this->authorRepository->shouldReceive('find')->once()->with(self::AUTHOR_ID, array('oeuvre'))->andReturn($this->author);

        $foundAuthor = $this->authorService->find(self::AUTHOR_ID);

        $this->assertEquals($foundAuthor, $this->author);
    }

}
