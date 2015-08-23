<?php

class BuyOrGiftWizardStepGoToStepTest extends TestCase
{
    const BOOK_ID = 1;
    const WIZARD_STEP = 4;
    const TITLE = "book title";
    const ISBN = "isbn";
    const COVER_TYPE = "type1";
    const USERNAME = 'John';

    private $currencies = array('EUR', 'PND');

    /** @var  BuyOrGiftWizardStep */
    private $buyOrGiftWizardStep;
    /** @var  BookService */
    private $bookService;
    /** @var  CurrencyService */
    private $currencyService;

    public function setUp()
    {
        parent::setUp();
        $this->bookService = $this->mock("BookService");
        $this->currencyService = $this->mock("CurrencyService");

        $this->buyOrGiftWizardStep = new BuyOrGiftWizardStep();

        $user = new User(['username' => self::USERNAME]);
        $this->be($user);
    }

    public function test_returnsWithCorrectVariables()
    {
        $this->markTestSkipped(
            'Test is not ready for test because formfiller does not use the bookservice to retrieve the book.'
        );

        $book = $this->createFakeBook();
        $this->bookService->shouldReceive('find')->andReturn($book);
        $this->currencyService->shouldReceive('getCurrencies')->andReturn($this->currencies);

        $book->wizard_step = self::WIZARD_STEP;
        $book->id = self::BOOK_ID;
        $book->title = self::TITLE;
        $book->ISBN = self::ISBN;

        $view = $this->buyOrGiftWizardStep->goToStep(self::BOOK_ID);

        $this->assertEquals($view['title'], self::TITLE);
        $this->assertEquals($view['book_id'], self::BOOK_ID);
        $this->assertEquals($view['book_wizard_step'], self::WIZARD_STEP);
        $this->assertEquals($view['currencies'], $this->currencies);
    }

}
