<?php

class BookService
{
    const PAGES = 1000;
    const COMPLETE = "COMPLETE";

    /** @var  BookRepository */
    private $bookRepository;
    /** @var  PublisherSerieService */
    private $publisherSerieService;
    /** @var  BookSerieService */
    private $bookSerieService;
    /** @var  BookFromAuthorService */
    private $bookFromAuthorService;
    /** @var  ImageService */
    private $imageService;
    /** @var  TagService */
    private $tagService;
    /** @var  LanguageService */
    private $languageService;
    /** @var  AuthorService */
    private $authorService;
    /** @var  PublisherService */
    private $publisherService;
    /** @var  CountryService */
    private $countryService;


    function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->publisherSerieService = App::make('PublisherSerieService');
        $this->bookSerieService = App::make('BookSerieService');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
        $this->imageService = App::make('ImageService');
        $this->tagService = App::make('TagService');
        $this->languageService = App::make('LanguageService');
        $this->authorService = App::make('AuthorService');
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
    }

    public function find($id, $with = array())
    {
        return $this->bookRepository->find($id, $with);
    }

    public function getWizardSteps($id = null)
    {
        return array(
            1 => (object)array('title' => 'Basis', 'link' => 'createOrEditBook/step/1/' . $id),
            2 => (object)array('title' => 'Extra', 'link' => 'createOrEditBook/step/2/' . $id),
            3 => (object)array('title' => 'Auteur', 'link' => 'createOrEditBook/step/3/' . $id),
            4 => (object)array('title' => 'Oeuvre', 'link' => 'createOrEditBook/step/4/' . $id),
            5 => (object)array('title' => 'Eerste druk', 'link' => 'createOrEditBook/step/5/' . $id),
            6 => (object)array('title' => 'Persoonlijk', 'link' => 'createOrEditBook/step/6/' . $id),
            7 => (object)array('title' => 'koop/gift', 'link' => 'createOrEditBook/step/7/' . $id),
            8 => (object)array('title' => 'Cover', 'link' => 'createOrEditBook/step/8/' . $id),
        );
    }

    public function getValueOfLibrary()
    {
        $this->bookRepository->getValueOfLibrary();
    }

    public function getTotalAmountOfBooksInLibrary()
    {
        return $this->bookRepository->getTotalAmountOfBooksInLibrary();
    }

    public function getTotalAmountOfBooksOwned()
    {
        return $this->bookRepository->getTotalAmountOfBooksOwned();
    }

    public function getOrderByValues()
    {
        return array('author' => 'Auteur', 'title' => 'Titel', 'subtitle' => 'Ondertitel', 'rating' => 'Waardering');
    }

    public function getBookCoverTypes()
    {
        return array("Hard cover" => "Hard cover", "Paperback" => "Paperback", "Dwarsligger" => "Dwarsligger", "E-book" => "E-book", "Luisterboek" => "Luisterboek");
    }

    public function getBookStates()
    {
        return array("Perfect" => "Perfect", "Bijna Perfect" => "Bijna Perfect", "Prima" => "Prima", "Redelijk" => "Redelijk", "Slecht" => "Slecht");
    }

    public function getBooks()
    {
        return Book::where('user_id', '=', Auth::user()->id)->get();
    }

    public function getCompletedBooksForList()
    {
        return Book::with('publisher', 'authors')->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->get();
    }

    public function getDraftBooksForList()
    {
        return Book::with('publisher', 'authors')
            ->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '!=', 'COMPLETE')
            ->get();
    }

    public function getCompletedBooksWithPersonalBookInfo()
    {
        return Book::with("personal_book_info")
            ->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->get();
    }

    public function getFullBook($book_id)
    {
        $with = array(
            'authors',
            'publisher',
            'genre',
            'personal_book_info',
            'first_print_info',
            'publication_date',
            'country',
            'publisher_serie',
            'serie');

        return Book::with($with)->where('user_id', '=', Auth::user()->id)
            ->where('id', '=', $book_id)
            ->first();
    }

    public function getAllFullBooks()
    {
        $with = array(
            'authors',
            'publisher',
            'genre',
            'personal_book_info',
            'first_print_info',
            'publication_date',
            'country',
            'publisher_serie',
            'serie');

        return Book::with($with)->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->get();
    }

    public function saveBasics(BookInfoParameters $bookInfoParameters)
    {
        $book = new Book();
        if (!StringUtils::isEmpty($bookInfoParameters->getBookId())) {
            $book = $this->bookRepository->find($bookInfoParameters->getBookId());
        }
        $book_publisher = $this->publisherService->findOrCreate($bookInfoParameters->getPublisherName());
        $country = $this->countryService->findOrCreate($bookInfoParameters->getCountryName());

        if (!StringUtils::isEmpty($bookInfoParameters->getLanguage())) {
            $book->language()->associate($this->languageService->findOrSave($bookInfoParameters->getLanguage()));
        } else {
            $book->language()->dissociate();
        }

        if ($bookInfoParameters->getPublicationDate() != null) {
            $book->publication_date()->associate($bookInfoParameters->getPublicationDate());
        } else {
            $book->publication_date()->dissociate();
        }

        $book->user_id = Auth::user()->id;
        $book->title = $bookInfoParameters->getTitle();
        $book->subtitle = $bookInfoParameters->getSubtitle();
        $book->ISBN = $bookInfoParameters->getIsbn();
        $book->genre_id = $bookInfoParameters->getGenre();
        $book->publisher_id = $book_publisher->id;
        $book->publisher_country_id = $country->id;
        $this->bookRepository->save($book);
        return $book;
    }

    public function setWizardStep($book, $nextStep)
    {
        $currentStep = $book->wizard_step;
        if ($currentStep != self::COMPLETE) {
            if ($currentStep < $nextStep) {
                $book->wizard_step = $nextStep;
                $book->save();
            }
        }
    }

    public function completeWizard($book)
    {
        $book->wizard_step = self::COMPLETE;
        $book->save();
    }

    public function saveExtras($book_id, ExtraBookInfoParameters $extraBookInfoParameters)
    {
        $book = $this->bookRepository->find($book_id);
        if ($book == null) {
            throw new ServiceException("book does not exist");
        }

        $book->number_of_pages = $extraBookInfoParameters->getPages();
        $book->print = $extraBookInfoParameters->getPrint();
        $book->translator = $extraBookInfoParameters->getTranslator();
        $book->state = $extraBookInfoParameters->getState();
        $book->summary = $extraBookInfoParameters->getSummary();
        $book->old_tags = $extraBookInfoParameters->getOldTags();
        $book->retail_price = $extraBookInfoParameters->getRetailPrice();
        $book->currency = $extraBookInfoParameters->getRetailPriceCurrency();
        if (!StringUtils::isEmpty($extraBookInfoParameters->getPublisherSerie())) {
            $publisherSerie = $this->publisherSerieService->findOrSave($extraBookInfoParameters->getPublisherSerie(), $book->publisher->id);
            $book->publisher_serie()->associate($publisherSerie);
        } else {
            $book->publisher_serie()->dissociate();
        }
        if (!StringUtils::isEmpty($extraBookInfoParameters->getBookSerie())) {
            $bookSerie = $this->bookSerieService->findOrSave($extraBookInfoParameters->getBookSerie());
            $book->serie()->associate($bookSerie);
        } else {
            $book->serie()->dissociate();
        }
        $this->bookRepository->save($book);
        return $book;
    }

    public function getFilteredBooks($book_id, BookFilterValues $bookFilterValues, $orderBy)
    {
        if ($book_id != null) {
            return Book::where('user_id', '=', Auth::user()->id)
                ->where('id', '=', $book_id)
                ->where('wizard_step', '=', 'COMPLETE')
                ->paginate(self::PAGES);
        }

        $books = Book::select(DB::raw('book.*'))
            ->leftJoin('serie', 'book.serie_id', '=', 'serie.id')
            ->leftJoin('publisher_serie', 'book.publisher_serie_id', '=', 'publisher_serie.id')
            ->leftJoin('book_author', 'book_author.book_id', '=', 'book.id')
            ->leftJoin('genre', 'genre.id', '=', 'book.genre_id')
            ->leftJoin('genre as genre_parent', 'genre.parent_id', '=', 'genre_parent.id')
            ->leftJoin('author', 'book_author.author_id', '=', 'author.id')
            ->leftJoin('personal_book_info', 'personal_book_info.book_id', '=', 'book.id')
            ->leftJoin('first_print_info', 'first_print_info.id', '=', 'book.first_print_info_id')
            ->leftJoin('date', 'date.id', '=', 'first_print_info.publication_date_id')
            ->where('book_author.preferred', '=', 1)
            ->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE');

        //FILTERS
        if ($bookFilterValues->getRead() == BookFilterValues::YES) {
            $books = $books->where("personal_book_info.read", '=', true);
        } else if ($bookFilterValues->getRead() == BookFilterValues::NO) {
            $books = $books->where("personal_book_info.read", '=', false);
        }

        if ($bookFilterValues->getOwns() == BookFilterValues::YES) {
            $books = $books->where("personal_book_info.owned", '=', true);
        } else if ($bookFilterValues->getOwns() == BookFilterValues::NO) {
            $books = $books->where("personal_book_info.owned", '=', false);
        }


        $operatorString = "=";
        $queryString = $bookFilterValues->getQuery();
        if (!StringUtils::isEmpty($queryString)) {
            if ($bookFilterValues->getOperator() == FilterOperator::BEGINS_WITH || $bookFilterValues->getOperator() == FilterOperator::CONTAINS || $bookFilterValues->getOperator() == FilterOperator::ENDS_WITH) {
                $operatorString = "LIKE";
                if ($bookFilterValues->getOperator() == FilterOperator::BEGINS_WITH) {
                    $queryString = $queryString . '%';
                }
                if ($bookFilterValues->getOperator() == FilterOperator::ENDS_WITH) {
                    $queryString = '%' . $queryString;
                }
                if ($bookFilterValues->getOperator() == FilterOperator::CONTAINS) {
                    $queryString = '%' . $queryString . '%';
                }
            }

            //SEARCH
            if ($bookFilterValues->getType() != BookFilterType::ALL) {
                $books = $books->where($bookFilterValues->getType(), $operatorString, $queryString);
            } else {
                $books = $books->where(function ($query) use ($operatorString, $queryString) {
                    $query->Where(BookFilterType::AUTHOR_NAME, $operatorString, $queryString)
                        ->orWhere(BookFilterType::AUTHOR_FIRSTNAME, $operatorString, $queryString)
                        ->orWhere(BookFilterType::PUBLISHER_SERIE, $operatorString, $queryString)
                        ->orWhere(BookFilterType::BOOK_SERIE, $operatorString, $queryString)
                        ->orWhere(BookFilterType::BOOK_GENRE, $operatorString, $queryString)
                        ->orWhere(BookFilterType::BOOK_TITLE, $operatorString, $queryString);
                });
            }
        }

        //ORDER BY
        if ($orderBy == 'title') {
            $books = $books->orderBy('title');
        }
        if ($orderBy == 'author') {
            $books = $books->orderBy('author.name');
        }
        if ($orderBy == 'subtitle') {
            $books = $books->orderBy('subtitle');
        }
        if ($orderBy == 'rating') {
            $books = $books->orderBy('personal_book_info.rating', 'DESC');
        }

        $books = $books->orderBy('author.name');
        $books = $books->orderBy('author.firstname');
        $books = $books->orderBy('date.year', 'ASC');
        $books = $books->orderBy('date.month', 'ASC');
        $books = $books->orderBy('date.day', 'ASC');

        return $books->paginate(self::PAGES);
    }

    public function searchCompletedBooks($criteria)
    {
        return Book::with(array(
            'authors' => function ($query) {
                $query->orderBy('name', 'DESC');
            },
            'publisher', 'genre', 'personal_book_info', 'first_print_info', 'publication_date', 'country', 'publisher_serie', 'serie'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->where(function ($query) use ($criteria) {
                $query->where('title', 'LIKE', '%' . $criteria . '%')
                    ->orWhere('subtitle', 'LIKE', '%' . $criteria . '%');
            })
            ->orderBy('title')
            ->paginate(self::PAGES);
    }

    /**
     * @param BookCreationParameters $bookCreationParameters
     * @return Book
     */
    public function createBook(BookCreationParameters $bookCreationParameters, Publisher $publisher, Country $country, FirstPrintInfo $firstPrintInfo, Author $author)
    {
        $book = new Book();
        if (!StringUtils::isEmpty($bookCreationParameters->getBookInfoParameters()->getBookId())) {
            $book = $this->bookRepository->find($bookCreationParameters->getBookInfoParameters()->getBookId());
        }
        $book->title = $bookCreationParameters->getBookInfoParameters()->getTitle();
        $book->subtitle = $bookCreationParameters->getBookInfoParameters()->getSubtitle();
        $book->ISBN = $bookCreationParameters->getBookInfoParameters()->getIsbn();
        $book->number_of_pages = $bookCreationParameters->getExtraBookInfoParameters()->getPages();
        $book->print = $bookCreationParameters->getExtraBookInfoParameters()->getPrint();
        $book->genre_id = $bookCreationParameters->getBookInfoParameters()->getGenre();
        $book->translator = $bookCreationParameters->getExtraBookInfoParameters()->getTranslator();
        $book->summary = $bookCreationParameters->getExtraBookInfoParameters()->getSummary();
        $book->state = $bookCreationParameters->getExtraBookInfoParameters()->getState();
        $book->old_tags = $bookCreationParameters->getExtraBookInfoParameters()->getOldTags();
        $book->type_of_cover = $bookCreationParameters->getCoverInfoParameters()->getCoverType();
        $book->user_id = Auth::user()->id;
        $book->retail_price = $bookCreationParameters->getBookInfoParameters()->getRetailPrice();
        $book->currency = $bookCreationParameters->getBookInfoParameters()->getCurrency();
        $book->publisher_id = $publisher->id;
        $book->publisher_country_id = $country->id;
        $book->first_print_info_id = $firstPrintInfo->id;

        $language = null;
        $publisherSerie = null;
        $bookSerie = null;
        $bookFromAuthor = null;

        if (!StringUtils::isEmpty($bookCreationParameters->getBookInfoParameters()->getLanguage())) {
            $language = $this->languageService->findOrSave($bookCreationParameters->getBookInfoParameters()->getLanguage());
        }
        if (!StringUtils::isEmpty($bookCreationParameters->getExtraBookInfoParameters()->getPublisherSerie())) {
            $publisherSerie = $this->publisherSerieService->findOrSave($bookCreationParameters->getExtraBookInfoParameters()->getPublisherSerie(), $publisher->id);
        }
        if (!StringUtils::isEmpty($bookCreationParameters->getExtraBookInfoParameters()->getBookSerie())) {
            $bookSerie = $this->bookSerieService->findOrSave($bookCreationParameters->getExtraBookInfoParameters()->getBookSerie());
        }
        if (!StringUtils::isEmpty($bookCreationParameters->getFirstAuthorInfoParameters()->getLinkedBook())) {
            $bookFromAuthor = $this->bookFromAuthorService->find($bookCreationParameters->getFirstAuthorInfoParameters()->getLinkedBook(), $author->id);
        }

        $this->bookRepository->setPublicationDate($book, $bookCreationParameters->getBookInfoParameters()->getPublicationDate());
        $this->bookRepository->setLanguage($book, $language);
        $this->bookRepository->setPublisherSerie($book, $publisherSerie);
        $this->bookRepository->setBookSerie($book, $bookSerie);
        $this->bookRepository->setBookFromAuthor($book, $bookFromAuthor);


        $this->saveImage($bookCreationParameters->getCoverInfoParameters(), $book);
        $this->bookRepository->save($book);
        return $book;
    }

    public function saveImage(CoverInfoParameters $coverInfoParameters, $book)
    {
        if ($coverInfoParameters->getImage() != null) {
            if ($book->image != 'images/questionCover.png' && !StringUtils::isEmpty($book->image)) {
                $this->imageService->removeBookImage($book->coverImage);
            }
            if ($coverInfoParameters->getImageSaveType() == ImageSaveType::UPLOAD) {
                $book->coverImage = $this->imageService->saveUploadImageForBook($coverInfoParameters->getImage(), $book);
            } else if ($coverInfoParameters->getImageSaveType() == ImageSaveType::URL) {
                $book->coverImage = $this->imageService->saveBookImageFromUrl($coverInfoParameters->getImage(), $book);
            } else if ($coverInfoParameters->getImageSaveType() == ImageSaveType::PATH) {
                $book->coverImage = $coverInfoParameters->getImage();
            }
            $book->useSpriteImage = false;
        }
    }

    public function getPreferredAuthor(Book $book)
    {
        foreach ($book->authors as $author) {
            if ($author->pivot->preferred == true) {
                return $author;
            }
        }
        return null;
    }

    public function getTotalAmountOfBooksRead()
    {
        return Book::join('personal_book_info', 'book_id', '=', 'book.id')
            ->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->where('personal_book_info.read', '=', 1)
            ->count();
    }

    public function getTotalAmountOfBooksUnRead()
    {
        return Book::join('personal_book_info', 'book_id', '=', 'book.id')
            ->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->where('personal_book_info.read', '=', 0)
            ->count();
    }

    public function getTotalAmountOfBooksBought()
    {
        return Book::join('personal_book_info', 'book_id', '=', 'book.id')
            ->join('buy_info', 'personal_book_info.id', '=', 'buy_info.personal_book_info_id')
            ->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->count();
    }

    public function getTotalAmountOfBooksGotten()
    {
        return Book::join('personal_book_info', 'book_id', '=', 'book.id')
            ->join('gift_info', 'personal_book_info.id', '=', 'gift_info.personal_book_info_id')
            ->where('user_id', '=', Auth::user()->id)
            ->where('wizard_step', '=', 'COMPLETE')
            ->count();
    }

    public function getAllTranslators(){
        return $this->bookRepository->getAllTranslators();
    }
}