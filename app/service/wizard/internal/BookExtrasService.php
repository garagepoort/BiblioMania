<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookExtrasService
{

    /** @var  BookRepository $bookRepository*/
    private $bookRepository;
    /** @var  BookSerieService */
    private $bookSerieService;
    /** @var  PublisherSerieService */
    private $publisherSerieService;
    /** @var BookService */
    private $bookService;

    public function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->bookSerieService = App::make('BookSerieService');
        $this->publisherSerieService = App::make('PublisherSerieService');
        $this->bookService = App::make('BookService');
    }

    public function updateBookExtras(UpdateBookExtrasRequest $updateBookExtrasRequest){
        /** @var Book $book */
        $book = $this->bookRepository->find($updateBookExtrasRequest->getId());
        Ensure::objectNotNull("Book", $book);

        $book->number_of_pages = $updateBookExtrasRequest->getPages();
        $book->print = $updateBookExtrasRequest->getPrint();
        $book->translator = $updateBookExtrasRequest->getTranslator();
        $book->state = $updateBookExtrasRequest->getState();
        $book->summary = $updateBookExtrasRequest->getSummary();
        $book->old_tags = $updateBookExtrasRequest->getOldTags();
        $book->retail_price = $updateBookExtrasRequest->getCoverPrice();
        $book->currency = $updateBookExtrasRequest->getCoverPriceCurrency();

        if (!StringUtils::isEmpty($updateBookExtrasRequest->getPublisherSeries())) {
            $publisherSerie = $this->publisherSerieService->findOrSave($updateBookExtrasRequest->getPublisherSeries(), $book->publisher->id);
            $book->publisher_serie()->associate($publisherSerie);
        } else {
            $book->publisher_serie()->dissociate();
        }

        if (!StringUtils::isEmpty($updateBookExtrasRequest->getBookSeries())) {
            $bookSerie = $this->bookSerieService->findOrSave($updateBookExtrasRequest->getBookSeries());
            $book->serie()->associate($bookSerie);
        } else {
            $book->serie()->dissociate();
        }

        $this->bookRepository->save($book);
        $this->bookService->setWizardStep($book, 2);
        return $book;
    }

}