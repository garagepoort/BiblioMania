<?php

class AuthorServiceTest extends TestCase {
    const NAME = "name";
    const FIRSTNAME = "firstname";
    const INFIX = "infix";
    const LINKED_BOOK = "linked_book";
    const IMAGE = "image";
    const IMAGE_PATH = "imagePath";

    /** @var  AuthorService */
    private $authorService;
    /** @var  ImageService */
    private $imageService;
    /** @var AuthorRepository */
    private $authorRepository;
    /** @var DateService */
    private $dateService;

    private $dateOfBirthMock;
    private $dateOfDeathMock;

    public function setUp(){
        parent::setUp();
        $this->imageService = $this->mock("ImageService");
        $this->dateService = $this->mock("DateService");
        $this->authorRepository = $this->mock("AuthorRepository");

        $this->dateOfBirthMock = Mockery::mock('Eloquent', 'Date');
        $this->dateOfDeathMock = Mockery::mock('Eloquent', 'Date');
        $this->dateOfBirthMock->shouldReceive('getAttribute')->with("id")->andReturn(12);
        $this->dateOfDeathMock->shouldReceive('getAttribute')->with("id")->andReturn(13);

        $this->authorService = App::make('AuthorService');
    }

    public function test_saveOrUpdate(){
        $authorInfoParameters = new AuthorInfoParameters(
            self::NAME,
            self::FIRSTNAME,
            self::INFIX,
            $this->dateOfBirthMock,
            $this->dateOfDeathMock,
            self::LINKED_BOOK,
            self::IMAGE,
            array(),
            true);

        $this->dateOfBirthMock->shouldReceive('save')->once();
        $this->dateOfDeathMock->shouldReceive('save')->once();

        $this->imageService->shouldReceive("saveUploadImage")->once()->with(self::IMAGE, self::NAME)->andReturn(self::IMAGE_PATH);
        $this->authorRepository->shouldReceive("getAuthorByFullName")->once()->with(self::NAME, self::FIRSTNAME, self::INFIX)->andReturn(null);
        $this->authorRepository->shouldReceive("save")->once();

        $author = $this->authorService->createOrUpdate($authorInfoParameters);

        $this->assertEquals($author->name, self::NAME);
        $this->assertEquals($author->firstname, self::FIRSTNAME);
        $this->assertEquals($author->infix, self::INFIX);
        $this->assertEquals($author->date_of_birth_id, 12);
        $this->assertEquals($author->date_of_death_id, 13);
        $this->assertEquals($author->image, self::IMAGE_PATH);
    }

    public function test_saveOrUpdate_whenImageFromUrl_savesImageFromUrl(){
        $authorInfoParameters = new AuthorInfoParameters(
            self::NAME,
            self::FIRSTNAME,
            self::INFIX,
            $this->dateOfBirthMock,
            $this->dateOfDeathMock,
            self::LINKED_BOOK,
            self::IMAGE,
            array(),
            ImageSaveType::URL);

        $this->dateOfBirthMock->shouldReceive('save')->once();
        $this->dateOfDeathMock->shouldReceive('save')->once();

        $this->imageService->shouldReceive("saveImageFromUrl")->once()->with(self::IMAGE, self::NAME)->andReturn(self::IMAGE_PATH);
        $this->authorRepository->shouldReceive("getAuthorByFullName")->once()->with(self::NAME, self::FIRSTNAME, self::INFIX)->andReturn(null);
        $this->authorRepository->shouldReceive("save")->once();
        $this->imageService->shouldReceive("removeImage")->once();

        $author = $this->authorService->createOrUpdate($authorInfoParameters);

        $this->assertEquals($author->name, self::NAME);
        $this->assertEquals($author->firstname, self::FIRSTNAME);
        $this->assertEquals($author->infix, self::INFIX);
        $this->assertEquals($author->date_of_birth_id, 12);
        $this->assertEquals($author->date_of_death_id, 13);
        $this->assertEquals($author->image, self::IMAGE_PATH);
    }

    public function test_saveOrUpdate_whenAuthorAlreadyExists_datesAreUpdatedFromAuthor(){
        $authorInfoParameters = new AuthorInfoParameters(
            self::NAME,
            self::FIRSTNAME,
            self::INFIX,
            $this->dateOfBirthMock,
            $this->dateOfDeathMock,
            self::LINKED_BOOK,
            self::IMAGE,
            array(),
            ImageSaveType::UPLOAD);

        $originalDateOfBirth = Mockery::mock('Eloquent', 'Date');
        $originalDateOfDeath = Mockery::mock('Eloquent', 'Date');
        $originalAuthor = new Author();
        $originalAuthor->name = self::NAME;
        $originalAuthor->firstname = self::FIRSTNAME;
        $originalAuthor->infix = self::INFIX;
        $originalAuthor->image = self::IMAGE;
        $originalAuthor->date_of_birth = $originalDateOfBirth;
        $originalAuthor->date_of_death = $originalDateOfDeath;

        $this->dateService->shouldReceive("copyDateValues")->once()->with($originalDateOfBirth, $this->dateOfBirthMock);
        $this->dateService->shouldReceive("copyDateValues")->once()->with($originalDateOfDeath, $this->dateOfDeathMock);

        $this->imageService->shouldReceive("saveUploadImage")->once()->with(self::IMAGE, self::NAME)->andReturn(self::IMAGE_PATH);
        $this->authorRepository->shouldReceive("getAuthorByFullName")->once()->with(self::NAME, self::FIRSTNAME, self::INFIX)->andReturn($originalAuthor);
        $this->authorRepository->shouldReceive("save")->once();
        $this->imageService->shouldReceive("removeImage")->once();

        $author = $this->authorService->createOrUpdate($authorInfoParameters);

        $this->assertEquals($originalAuthor, $author);
        $this->assertEquals($originalAuthor->name, $author->name);
        $this->assertEquals($originalAuthor->firstname, $author->firstname);
        $this->assertEquals($originalAuthor->infix, $author->infix);
        $this->assertEquals($originalDateOfBirth, $author->date_of_birth);
        $this->assertEquals($originalDateOfDeath, $author->date_of_death);
        $this->assertEquals($originalAuthor->image, $author->image);
    }

    public function testSaveImage_whenImageGivenNull_andPreviousImageFilled_keepsPreviousImage(){
        $author = new Author();
        $previousImage = "pervieofeiowh";
        $author->image = $previousImage;

        $authorInfoParameters = new AuthorInfoParameters('name', 'firstname', 'infix', null, null, null, null, array(), false);

        $this->authorService->saveImage($authorInfoParameters->getImage(), $authorInfoParameters->getImageSaveType(), $author);

        $this->assertEquals($previousImage, $author->image);
    }
}
