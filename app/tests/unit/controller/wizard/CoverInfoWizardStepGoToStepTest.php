<?php

class CoverInfoWizardStepGoToStepTest extends TestCase
{
    const BOOK_ID = 1;
    const WIZARD_STEP = 4;
    const TITLE = "book title";
    const ISBN = "isbn";
    const COVER_TYPE = "type1";
    const USERNAME = 'John';
    const COVER_IMAGE = "coverImage";

    /** @var  CoverInfoWizardStep */
    private $coverInfoWizardStep;
    /** @var  BookService */
    private $bookService;
    private $covertypes = array("type1", "type2");

    public function setUp()
    {
        parent::setUp();
        $this->bookService = $this->mock("BookService");
        $this->coverInfoWizardStep = new CoverInfoWizardStep();

        $user = new User(['username' => self::USERNAME]);
        $this->be($user);
    }

    public function test_returnsWithCorrectVariables()
    {
        $this->bookService->shouldReceive('getBookCoverTypes')->andReturn($this->covertypes);
        $book = $this->createFakeBook();
        $this->bookService->shouldReceive('find')->andReturn($book);

        $book->wizard_step = self::WIZARD_STEP;
        $book->id = self::BOOK_ID;
        $book->title = self::TITLE;
        $book->ISBN = self::ISBN;
        $book->type_of_cover = self::COVER_TYPE;

        $view = $this->coverInfoWizardStep->goToStep(self::BOOK_ID);

        $this->assertEquals($view['title'], "Cover");
        $this->assertEquals($view['book_id'], self::BOOK_ID);
        $this->assertEquals($view['book_wizard_step'], self::WIZARD_STEP);
        $this->assertEquals($view['book_isbn'], self::ISBN);
        $this->assertEquals($view['book_title'], self::TITLE);
        $this->assertEquals($view['author_name'], "authorName authorFirstName");
        $this->assertEquals($view['book_type_of_cover'], self::COVER_TYPE);
    }


    public function test_returnsQuestionImageAsImage_whenNoCoverImageSet()
    {
        $this->bookService->shouldReceive('getBookCoverTypes')->andReturn($this->covertypes);
        $book = $this->createFakeBook();
        $this->bookService->shouldReceive('find')->andReturn($book);

        $book->coverImage = null;

        $view = $this->coverInfoWizardStep->goToStep(self::BOOK_ID);

        $this->assertEquals($view['book_cover_image'], Config::get("properties.questionImage"));
    }

    public function test_returnsImage_whenCoverImageSet()
    {
        $this->bookService->shouldReceive('getBookCoverTypes')->andReturn($this->covertypes);
        $book = $this->createFakeBook();
        $this->bookService->shouldReceive('find')->andReturn($book);

        $book->coverImage = self::COVER_IMAGE;

        $view = $this->coverInfoWizardStep->goToStep(self::BOOK_ID);

        $this->assertEquals($view['book_cover_image'], Config::get("properties.bookImagesLocation") . "/" . self::USERNAME . "/" . self::COVER_IMAGE);
    }


}
