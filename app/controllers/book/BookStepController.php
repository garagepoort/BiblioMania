<?php

class BookStepController extends BaseController
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  BookFormValidator */
    private $bookFormValidator;
    /** @var  BookCreationService */
    private $bookCreationService;
    /** @var  AuthorInfoParameterMapper */
    private $authorInfoParameterMapper;
    /** @var  ExtraBookInfoParameterMapper */
    private $extraBookInfoParameterMapper;
    /** @var  BookInfoParameterMapper */
    private $bookInfoParameterMapper;
    /** @var  BuyInfoParameterMapper */
    private $buyInfoParameterMapper;
    /** @var  GiftInfoParameterMapper */
    private $giftInfoParameterMapper;
    /** @var  CoverInfoParameterMapper */
    private $coverInfoParameterMapper;
    /** @var  FirstPrintInfoParameterMapper */
    private $firstPrintInfoParameterMapper;
    /** @var  PersonalBookInfoParameterMapper */
    private $personalBookInfoParameterMapper;
    /** @var  CountryService */
    private $countryService;
    /** @var  LanguageService */
    private $languageService;
    /** @var  CurrencyService */
    private $currencyService;
    /** @var  AuthorService */
    private $authorService;


    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->currencyService = App::make('CurrencyService');
        $this->bookFormValidator = App::make('BookFormValidator');
        $this->bookCreationService = App::make('BookCreationService');
        $this->authorInfoParameterMapper = App::make('AuthorInfoParameterMapper');
        $this->extraBookInfoParameterMapper = App::make('ExtraBookInfoParameterMapper');
        $this->bookInfoParameterMapper = App::make('BookInfoParameterMapper');
        $this->buyInfoParameterMapper = App::make('BuyInfoParameterMapper');
        $this->giftInfoParameterMapper = App::make('GiftInfoParameterMapper');
        $this->coverInfoParameterMapper = App::make('CoverInfoParameterMapper');
        $this->firstPrintInfoParameterMapper = App::make('FirstPrintInfoParameterMapper');
        $this->personalBookInfoParameterMapper = App::make('PersonalBookInfoParameterMapper');
        $this->countryService = App::make('CountryService');
        $this->languageService = App::make('LanguageService');
        $this->authorService = App::make('AuthorService');
    }


    public function goToBookStep1($id = null)
    {
        $genres = Genre::where('parent_id', '=', null)->get();
        if ($id == null) {
            $withArray = BookFormFiller::createArrayForCreate();
        } else {
            $withArray = BookFormFiller::fillBasicInfo($id);
        }

        $withArray['title'] = 'Boek basis';
        $withArray['wizardSteps'] = $this->getSteps();
        $withArray['languages'] = $this->languageService->getLanguagesMap();
        $withArray['currencies'] = $this->currencyService->getCurrencies();
        $withArray['genres'] = $genres;
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        $withArray['publishers_json'] = json_encode(Publisher::all());
        $withArray['tags_json'] = json_encode(Tag::all());
        $withArray['series_json'] = json_encode(Serie::all());
        $withArray['publisher_series_json'] = json_encode(PublisherSerie::all());
        return View::make($this->bookFolder . 'bookBasics')->with($withArray);
    }

    public function saveBookStep1()
    {
        $validator = $this->bookFormValidator->createValidatorForBasics();

        if ($validator->fails()) {
            if (Input::get('book_id') != '') {
                $book_id = Input::get('book_id');
                return Redirect::to('/createOrEditBook/step1/' . $book_id)->withErrors($validator)->withInput();
            }
            return Redirect::to('/createOrEditBook/step1')->withErrors($validator)->withInput();
        } else {
            $bookInfoParameters = $this->bookInfoParameterMapper->createForBasics();
            $book = $this->bookService->saveBasics($bookInfoParameters);
            $this->bookService->setWizardStep($book, 2);
            return Redirect::to('/createOrEditBook/step2/' . $book->id);
        }
    }

    public function goToBookStep2($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 2);
        if($result != null){
            return $result;
        }
        $withArray = BookFormFiller::fillForBookExtras($id);
        $withArray['title'] = 'Boek extras';
        $withArray['wizardSteps'] = $this->getSteps();
        $withArray['tags_json'] = json_encode(Tag::all());
        $withArray['series_json'] = json_encode(Serie::all());
        $withArray['states'] = $this->bookService->getBookStates();;
        $withArray['currencies'] = $this->currencyService->getCurrencies();
        $withArray['publisher_series_json'] = json_encode(PublisherSerie::all());
        return View::make($this->bookFolder . 'bookExtra')->with($withArray);
    }

    public function saveBookStep2($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 2);
        if($result != null){
            return $result;
        }
        $bookExtras = $this->extraBookInfoParameterMapper->createForWizard();
        $book = $this->bookService->saveExtras($id, $bookExtras);
        $this->bookService->setWizardStep($book, 3);
        return $this->redirectToCorrectStep($book->id, '/createOrEditBook/step1/', '/createOrEditBook/step3/');
    }

    public function goToBookStep3($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 3);
        if($result != null){
            return $result;
        }
        $withArray = BookFormFiller::fillForAuthor($id);
        $withArray['title'] = 'Auteur';
        $withArray['wizardSteps'] = $this->getSteps();
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        return View::make($this->bookFolder . 'author')->with($withArray);
    }

    public function saveBookStep3($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 3);
        if($result != null){
            return $result;
        }
        /** @var AuthorInfoParameters $preferredAuthorParams */
        $preferredAuthorParams = $this->authorInfoParameterMapper->create();
        $secondaryAuthorParameters = $this->authorInfoParameterMapper->createSecondaryAuthors();

        $book = $this->bookCreationService->saveAuthorsToBook($id, $preferredAuthorParams, $secondaryAuthorParameters);

        $this->bookService->setWizardStep($book, 4);
        return $this->redirectToCorrectStep($id, '/createOrEditBook/step2/', '/createOrEditBook/step4/');
    }

    public function goToBookStep4($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 4);
        if($result != null){
            return $result;
        }
        $withArray = BookFormFiller::fillForFirstPrint($id);
        $withArray['title'] = 'Eerste druk';
        $withArray['wizardSteps'] = $this->getSteps();
        $withArray['languages'] = $this->languageService->getLanguagesMap();
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['publishers_json'] = json_encode(Publisher::all());
        return View::make($this->bookFolder . 'firstprint')->with($withArray);
    }

    public function saveBookStep4($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 4);
        if($result != null){
            return $result;
        }
        $firstPrintParameters = $this->firstPrintInfoParameterMapper->create();
        $book = $this->bookCreationService->saveFirstPrintForBook($id, $firstPrintParameters);
        $this->bookService->setWizardStep($book, 5);
        return $this->redirectToCorrectStep($id, '/createOrEditBook/step3/', '/createOrEditBook/step5/');
    }

    public function goToBookStep5($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 5);
        if($result != null){
            return $result;
        }
        $withArray = BookFormFiller::fillForPersonalInfo($id);
        $withArray['title'] = 'Persoonlijke informatie';
        $withArray['wizardSteps'] = $this->getSteps();
        return View::make($this->bookFolder . 'personalinfo')->with($withArray);
    }

    public function saveBookStep5($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 5);
        if($result != null){
            return $result;
        }
        $personalParams = $this->personalBookInfoParameterMapper->create();
        $book = $this->bookCreationService->savePersonalInformationForBook($id, $personalParams);
        $this->bookService->setWizardStep($book, 6);
        return $this->redirectToCorrectStep($id, '/createOrEditBook/step4/', '/createOrEditBook/step6/');
    }

    public function goToBookStep6($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 6);
        if($result != null){
            return $result;
        }
        $withArray = BookFormFiller::fillForBuyInfo($id);
        $withArray['wizardSteps'] = $this->getSteps();
        $withArray['currencies'] = $this->currencyService->getCurrencies();
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['title'] = 'Persoonlijke informatie';
        return View::make($this->bookFolder . 'buyOrGiftInfo')->with($withArray);
    }

    public function saveBookStep6($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 6);
        if($result != null){
            return $result;
        }
        $buyInfo = $this->buyInfoParameterMapper->create();
        $giftInfo = $this->giftInfoParameterMapper->create();
        $isBought = Input::get('buyOrGift') == 'BUY';

        if($isBought){
            $book = $this->bookCreationService->saveBuyInfoForBook($id, $buyInfo);
        }else{
            $book = $this->bookCreationService->saveGiftInfoForBook($id, $giftInfo);
        }
        $this->bookService->setWizardStep($book, 7);
        return $this->redirectToCorrectStep($id, '/createOrEditBook/step5/', '/createOrEditBook/step7/');
    }

    public function goToBookStep7($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 7);
        if($result != null){
            return $result;
        }
        $covers = $this->bookService->getBookCoverTypes();
        $withArray = BookFormFiller::fillForCover($id);
        $withArray['title'] = 'Cover';
        $withArray['wizardSteps'] = $this->getSteps();
        $withArray['covers'] = $covers;
        return View::make($this->bookFolder . 'cover')->with($withArray);
    }

    public function saveBookStep7($id)
    {
        $result = $this->checkIsAllowedToBeInStep($id, 7);
        if($result != null){
            return $result;
        }
        $coverInfoParameters = $this->coverInfoParameterMapper->create();
        $book = $this->bookCreationService->saveCoverInfoToBook($id, $coverInfoParameters);
        $this->bookService->setWizardStep($book, 8);
        return $this->redirectToCorrectStep($id, '/createOrEditBook/step6/', '/getBooks?scroll_id=');
    }

    private function checkIsAllowedToBeInStep($id, $step){
        $book = $this->checkBookExists($id);
        if($book->wizard_step != "COMPLETE" &&  $book->wizard_step < $step){
            return Redirect::to("/createOrEditBook/step". $book->wizard_step ."/" . $id);
        }
        return null;
    }

    private function checkBookExists($id){
        $book = $this->bookService->find($id);
        if($book == null){
            throw new Exception("Book given does not exist");
        }
        return $book;
    }

    private function getSteps(){
        return array(
            1=>"Basis",
            2=>"Extra",
            3=>"Auteur",
            4=>"Eerste druk",
            5=>"Persoonlijk",
            6=>"koop/gift",
            7=>"Cover",
        );
    }

    /**
     * @param $book
     * @param $previousPath
     * @param $nextPath
     * @return mixed
     */
    public function redirectToCorrectStep($book_id, $previousPath, $nextPath)
    {
        $redirectTo = Input::get('redirect');
        if ($redirectTo == "PREVIOUS") {
            return Redirect::to($previousPath . $book_id);
        } else {
            return Redirect::to($nextPath . $book_id);
        }
    }
}