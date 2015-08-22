<?php

class BookCreationService
{
    /** @var  AuthorService */
    private $authorService;
    /** @var  PublisherService */
    private $publisherService;
    /** @var  CountryService */
    private $countryService;
    /** @var  BookService */
    private $bookService;
    /** @var  FirstPrintInfoService */
    private $firstPrintInfoService;
    /** @var  PersonalBookInfoService */
    private $personalBookInfoService;
    /** @var  BuyInfoService */
    private $buyInfoService;
    /** @var  GiftInfoService */
    private $giftInfoService;
    /** @var  OeuvreService */
    private $oeuvreService;
    /** @var  TagService */
    private $tagService;
    /** @var  BookFromAuthorService */
    private $bookFromAuthorService;

    function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
        $this->bookService = App::make('BookService');
        $this->firstPrintInfoService = App::make('FirstPrintInfoService');
        $this->personalBookInfoService = App::make('PersonalBookInfoService');
        $this->buyInfoService = App::make('BuyInfoService');
        $this->giftInfoService = App::make('GiftInfoService');
        $this->oeuvreService = App::make('OeuvreService');
        $this->tagService = App::make('TagService');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
    }

    public function saveAuthorsToBook($book_id, AuthorInfoParameters $preferredAuthorParams, $secondaryAuthorParameters){
        $book = $this->bookService->getFullBook($book_id);
        if($book == null){
            throw new ServiceException("Book given does not exist");
        }

        $preferredAuthor = $this->authorService->createOrUpdate($preferredAuthorParams);

        $this->oeuvreService->saveBookFromAuthors($preferredAuthorParams->getOeuvre(), $preferredAuthor->id);

        $secondaryAuthors = array();
        foreach ($secondaryAuthorParameters as $secondaryParam) {
            array_push($secondaryAuthors, $this->authorService->saveOrGetSecondaryAuthor($secondaryParam));
        }

        $this->syncAuthors($preferredAuthor, $secondaryAuthors, $book);
        $book->save();
        return $book;
    }

    public function savePersonalInformationForBook($book_id, PersonalBookInfoParameters $personalBookInfoParameters)
    {
        $book = $this->bookService->getFullBook($book_id);
        if($book == null){
            throw new ServiceException("Book given does not exist");
        }
        $this->personalBookInfoService->findOrCreate($personalBookInfoParameters, $book);
        return $book;
    }

    public function saveBuyInfoForBook($book_id, BuyInfoParameters $buyInfoParameters)
    {
        $book = $this->bookService->getFullBook($book_id);
        if($book == null){
            throw new ServiceException("Book given does not exist");
        }
        $this->buyInfoService->findOrCreate($buyInfoParameters, $book->personal_book_info);
        $this->giftInfoService->delete($book->personal_book_info->id);
        return $book;
    }

    public function saveGiftInfoForBook($book_id, GiftInfoParameters $giftInfoParameters)
    {
        $book = $this->bookService->getFullBook($book_id);
        if($book == null){
            throw new ServiceException("Book given does not exist");
        }
        $this->giftInfoService->findOrCreate($giftInfoParameters, $book->personal_book_info);
        $this->buyInfoService->delete($book->personal_book_info->id);
        return $book;
    }

    public function saveFirstPrintForBook($book_id, FirstPrintInfoParameters $firstPrintInfoParameters){
        $book = $this->bookService->getFullBook($book_id);
        if($book == null){
            throw new ServiceException("Book given does not exist");
        }
        $firstPrintInfo = $this->firstPrintInfoService->findOrCreate($firstPrintInfoParameters);

        $book->first_print_info_id = $firstPrintInfo->id;
        $book->save();
        return $book;
    }

    public function saveCoverInfoToBook($book_id, $coverInfoParameters)
    {
        $book = $this->bookService->getFullBook($book_id);
        if($book == null){
            throw new ServiceException("Book given does not exist");
        }
        $book->type_of_cover = $coverInfoParameters->getCoverType();
        $this->bookService->saveImage($coverInfoParameters, $book);
        $book->save();
        return $book;
    }

    public function createBook(BookCreationParameters $bookCreationParameters)
    {

        $book = DB::transaction(function () use ($bookCreationParameters) {
            $tags = $this->tagService->createTags($bookCreationParameters->getBookInfoParameters()->getTags());

            $preferredAuthor = $this->authorService->createOrUpdate($bookCreationParameters->getFirstAuthorInfoParameters());
            $this->oeuvreService->saveBookFromAuthors($bookCreationParameters->getFirstAuthorInfoParameters()->getOeuvre(), $preferredAuthor->id);

            $secondaryAuthors = array();
            foreach ($bookCreationParameters->getSecondaryAuthorsInfoParameters() as $secondaryParam) {
                array_push($secondaryAuthors, $this->authorService->saveOrGetSecondaryAuthor($secondaryParam));
            }

            $book_publisher = $this->publisherService->findOrCreate(
                $bookCreationParameters->getBookInfoParameters()->getPublisherName()
            );

            $first_print_info = $this->firstPrintInfoService->findOrCreate($bookCreationParameters->getFirstPrintInfoParameters());
            $country = $this->countryService->findOrCreate($bookCreationParameters->getBookInfoParameters()->getCountryName());

            $book = $this->bookService->createBook($bookCreationParameters, $book_publisher, $country, $first_print_info, $preferredAuthor);

            $this->syncAuthors($preferredAuthor, $secondaryAuthors, $book);
            $book->tags()->sync($tags);

            $personalBookInfo = $this->personalBookInfoService->findOrCreate($bookCreationParameters->getPersonalBookInfoParameters(), $book);

            if ($bookCreationParameters->isBuyInfo()) {
                $this->buyInfoService->findOrCreate($bookCreationParameters->getBuyInfoParameters(), $personalBookInfo);
                $this->giftInfoService->delete($personalBookInfo->id);
            } else {
                $this->giftInfoService->findOrCreate($bookCreationParameters->getGiftInfoParameters(), $personalBookInfo);
                $this->buyInfoService->delete($personalBookInfo->id);
            }
            return $book;
        });

        return $book;
    }

    private function syncAuthors($preferredAuthor, $secondaryAuthors, $book)
    {
        $authors = array($preferredAuthor->id => array('preferred' => true));
        foreach ($secondaryAuthors as $secAuthor) {
            $authors[$secAuthor->id] = array('preferred' => false);
        }
        $book->authors()->sync($authors);
    }
}