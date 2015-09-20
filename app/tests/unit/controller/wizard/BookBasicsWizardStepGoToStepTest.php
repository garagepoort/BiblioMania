<?php

class BookBasicsWizardStepGoToStepTest extends TestCase
{
    const BOOK_ID = 1;
    const WIZARD_STEP = 4;
    const TITLE = "book title";
    const ISBN = "isbn";
    const COVER_TYPE = "type1";
    const USERNAME = 'John';

    private $languages = array('nederlands', 'duits');
    private $currencies = array('EUR', 'PND');
    private $genres = array("genres");

    /** @var  BookBasicsWizardStep */
    private $bookBasicsWizardStep;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var  LanguageService */
    private $languageService;
    /** @var  CurrencyService */
    private $currencyService;
    /** @var  GenreService */
    private $genreService;

    public function setUp()
    {
        parent::setUp();
        $this->bookRepository = $this->mock("BookRepository");
        $this->languageService = $this->mock("LanguageService");
        $this->currencyService = $this->mock("CurrencyService");
        $this->genreService = $this->mock("GenreService");

        $this->bookBasicsWizardStep = new BookBasicsWizardStep();

        $user = new User(['username' => self::USERNAME]);
        $this->be($user);
    }

    public function test_returnsWithCorrectVariables()
    {
        $book = $this->createFakeBook();
        $this->bookRepository->shouldReceive('find')->andReturn($book);
        $this->languageService->shouldReceive('getLanguagesMap')->andReturn($this->languages);
        $this->currencyService->shouldReceive('getCurrencies')->andReturn($this->currencies);
        $this->genreService->shouldReceive('getAllParentGenres')->andReturn($this->genres);

        $book->wizard_step = self::WIZARD_STEP;
        $book->id = self::BOOK_ID;
        $book->title = self::TITLE;
        $book->ISBN = self::ISBN;

        $view = $this->bookBasicsWizardStep->goToStep(self::BOOK_ID);

        $this->assertEquals($view['title'], self::TITLE);
        $this->assertEquals($view['book_id'], self::BOOK_ID);
        $this->assertEquals($view['book_wizard_step'], self::WIZARD_STEP);
        $this->assertEquals($view['book_isbn'], self::ISBN);
        $this->assertEquals($view['book_title'], self::TITLE);
        $this->assertEquals($view['languages'], $this->languages);
        $this->assertEquals($view['currencies'], $this->currencies);
        $this->assertEquals($view['genres'], $this->genres);
    }

}
