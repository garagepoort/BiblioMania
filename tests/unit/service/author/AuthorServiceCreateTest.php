<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class AuthorServiceCreateTest extends TestCase {
    const DATE_OF_BIRTH_ID = 12;
    const DATE_OF_DEATH_ID = 13;
    const SAVED_IMAGE_FILE = 'savedImageFile';

    /** @var  AuthorService */
    private $authorService;
    /** @var  ImageService */
    private $imageService;
    /** @var AuthorRepository */
    private $authorRepository;
    /** @var DateService $dateService*/
    private $dateService;
    /** @var Author $author */
    private $author;

    private $dateOfBirthMock;
    private $dateOfDeathMock;

    /** @var  CreateAuthorRequestTestImpl */
    private $createAuthorRequest;

    public function setUp(){
        parent::setUp();
        $this->createAuthorRequest = new CreateAuthorRequestTestImpl();

        $this->imageService = $this->mock("ImageService");
        $this->dateService = $this->mock("DateService");
        $this->authorRepository = $this->mock("AuthorRepository");

        $this->author = $this->mockEloquent('Author');
        $this->dateOfBirthMock = $this->mockEloquent('Date');
        $this->dateOfDeathMock = $this->mockEloquent('Date');
        $this->dateOfBirthMock->shouldReceive('getAttribute')->with("id")->andReturn(self::DATE_OF_BIRTH_ID);
        $this->dateOfDeathMock->shouldReceive('getAttribute')->with("id")->andReturn(self::DATE_OF_DEATH_ID);

        $this->authorService = App::make('AuthorService');
    }

    public function test_shouldCreateCorrect(){
        $this->dateService->shouldReceive('create')->once()
            ->with($this->createAuthorRequest->getDateOfBirth())
            ->andReturn($this->dateOfBirthMock)->byDefault();

        $this->dateService->shouldReceive('create')->once()
            ->with($this->createAuthorRequest->getDateOfDeath())
            ->andReturn($this->dateOfDeathMock)->byDefault();

        $this->authorRepository->shouldReceive('updateAuthorDateOfBirth')->once()->with(Mockery::any(), self::DATE_OF_BIRTH_ID);
        $this->authorRepository->shouldReceive('updateAuthorDateOfDeath')->once()->with(Mockery::any(), self::DATE_OF_DEATH_ID);

        $this->imageService->shouldReceive('saveAuthorImageFromUrl')->once()->with($this->createAuthorRequest->getImageUrl(), Mockery::any())
            ->andReturn(self::SAVED_IMAGE_FILE)->byDefault();

        $this->authorRepository->shouldReceive('save')->once()
            ->with(Mockery::on(function($author){
                $this->assertEquals($author->name, $this->createAuthorRequest->getName()->getLastname());
                $this->assertEquals($author->firstname, $this->createAuthorRequest->getName()->getFirstname());
                $this->assertEquals($author->infix, $this->createAuthorRequest->getName()->getInfix());
                $this->assertEquals($author->image, self::SAVED_IMAGE_FILE);
                return true;
            }));

        $createdAuthor = $this->authorService->create($this->createAuthorRequest);

        $this->assertEquals($createdAuthor->name, $this->createAuthorRequest->getName()->getLastname());
        $this->assertEquals($createdAuthor->firstname, $this->createAuthorRequest->getName()->getFirstname());
        $this->assertEquals($createdAuthor->infix, $this->createAuthorRequest->getName()->getInfix());
        $this->assertEquals($createdAuthor->image, self::SAVED_IMAGE_FILE);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object author create request name can not be null.
     */
    public function test_shouldThrowExceptionWhenNameIsNull(){
        $this->createAuthorRequest->setName(null);

        $this->authorService->create($this->createAuthorRequest);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage error.author.can.not.be.created.author.already.exists.with.same.name
     */
    public function test_shouldThrowExceptionWhenAuthorWithSameNameAlreadyExists(){
        $this->authorRepository->shouldReceive('getAuthorByFullName')
            ->with($this->createAuthorRequest->getName()->getLastname(), $this->createAuthorRequest->getName()->getFirstname(), $this->createAuthorRequest->getName()->getInfix())
            ->once()
            ->andReturn($this->author);

        $this->authorService->create($this->createAuthorRequest);
    }
}
