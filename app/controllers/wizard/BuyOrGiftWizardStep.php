<?php

class BuyOrGiftWizardStep extends WizardStep
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  BuyInfoParameterMapper */
    private $buyInfoParameterMapper;
    /** @var  GiftInfoParameterMapper */
    private $giftInfoParameterMapper;
    /** @var  BookCreationService */
    private $bookCreationService;
    /** @var  CountryService */
    private $countryService;
    /** @var  CurrencyService */
    private $currencyService;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->buyInfoParameterMapper = App::make('BuyInfoParameterMapper');
        $this->giftInfoParameterMapper = App::make('GiftInfoParameterMapper');
        $this->bookCreationService = App::make('BookCreationService');
        $this->countryService = App::make('CountryService');
        $this->currencyService = App::make('CurrencyService');
    }

    public function executeStep($id = null)
    {
        $buyInfo = $this->buyInfoParameterMapper->create();
        $giftInfo = $this->giftInfoParameterMapper->create();
        $isBought = Input::get('buyOrGift') == 'BUY';

        if($isBought){
            $book = $this->bookCreationService->saveBuyInfoForBook($id, $buyInfo);
        }else{
            $book = $this->bookCreationService->saveGiftInfoForBook($id, $giftInfo);
        }
        return $book;
    }

    public function goToStep($id = null)
    {
        $withArray = BookFormFiller::fillForBuyInfo($id);
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps($id);
        $withArray['currencies'] = $this->currencyService->getCurrencies();
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['title'] = 'Persoonlijke informatie';
        return View::make($this->bookFolder . 'buyOrGiftInfo')->with($withArray);
    }
}