<?php

class AuthorServiceIT extends AbstractIntegrationTestCase{

    /** @var  AuthorService */
    private $authorService;
    /** @var AuthorRepository */
    private $authorRepository;

    public function setUp(){
        parent::setUp();
        $this->authorService = App::make('AuthorService');
        $this->authorRepository = App::make('AuthorRepository');
    }

    public function test_createOrUpdate_createsAuthorCorrect(){
        $authorInfoParameters = new AuthorInfoParameters("name", "firstname", "infix", null, null, "linked_book", null, "oeuvre");

        $author = $this->authorService->createOrUpdate($authorInfoParameters);

        $savedAuthor = $this->authorRepository->find($author->id);

        $this->assertEquals($savedAuthor->name, "name");
        $this->assertEquals($savedAuthor->firstname, "firstname");
        $this->assertEquals($savedAuthor->infix, "infix");
        $this->assertNotNull($savedAuthor->date_of_birth);
        $this->assertNotNull($savedAuthor->date_of_death);
    }
}