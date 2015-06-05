<?php

class BookFromAuthorServiceTest extends TestCase {

    /** @var  BookFromAuthorService */
    private $bookFromAuthorService;
    /** @var  AuthorRepository */
    private $authorRepository;
    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;

    function setUp()
    {
        parent::setUp();
        $this->authorRepository = $this->mock('AuthorRepository');
        $this->bookFromAuthorRepository = $this->mock('BookFromAuthorRepository');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
    }

    public function testSave_savesCorrect(){
        $author = new Author();
        $title = 'title';
        $author_id = 11;
        $year = 1234;

        $this->authorRepository->shouldReceive('find')->with($author_id)->andReturn($author);
        $this->bookFromAuthorRepository->shouldReceive('findByTitle')->with($author_id, $title)->andReturn(null);
        $this->bookFromAuthorRepository->shouldReceive('save')->once();

        $savedBookFromAuthor = $this->bookFromAuthorService->save($author_id, $title, $year);

        $this->assertEquals($title, $savedBookFromAuthor->title);
        $this->assertEquals($author_id, $savedBookFromAuthor->author_id);
        $this->assertEquals($year, $savedBookFromAuthor->publication_year);
    }

    /**
     * @expectedException ServiceException
     */
    public function testSave_WhenAuthorDoesNotExist_throwsException(){
        $title = 'title';
        $author_id = 11;
        $this->authorRepository->shouldReceive('find')->with($author_id)->andReturn(null);
        $this->bookFromAuthorRepository->shouldReceive('findByTitle')->with($author_id, $title)->andReturn(null);

        $this->bookFromAuthorService->save($author_id, $title, 1234);
    }

    /**
     * @expectedException ServiceException
     */
    public function testSave_WhenBookFromAuthorAlreadyExists_throwsException(){
        $author = new Author();
        $bookFromAuthor = new BookFromAuthor();
        $title = 'title';
        $author_id = 11;
        $this->authorRepository->shouldReceive('find')->with($author_id)->andReturn($author);
        $this->bookFromAuthorRepository->shouldReceive('findByTitle')->with($author_id, $title)->andReturn($bookFromAuthor);

        $this->bookFromAuthorService->save($author_id, $title, 1234);
    }
}
