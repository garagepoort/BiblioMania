<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookAuthorService
{

    /** @var  BookRepository $bookRepository*/
    private $bookRepository;
    /** @var  BookSerieService */
    private $bookSerieService;
    /** @var  PublisherSerieService */
    private $publisherSerieService;
    /** @var BookService */
    private $bookService;
    /** @var AuthorService */
    private $authorService;

    public function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->bookSerieService = App::make('BookSerieService');
        $this->publisherSerieService = App::make('PublisherSerieService');
        $this->bookService = App::make('BookService');
        $this->authorService = App::make('AuthorService');
    }

    public function updateBookAuthor(UpdateBookAuthorRequest $updateBookAuthorRequest){
        /** @var Book $book */
        $book = $this->bookService->getFullBook($updateBookAuthorRequest->getId());
        if($book == null){
            throw new ServiceException("Book given does not exist");
        }

        $preferredAuthor = $this->authorService->createOrFindAuthor($updateBookAuthorRequest->getPreferredAuthor());
        $secondaryAuthors = $this->saveSecondaryAuthors($updateBookAuthorRequest);
        $this->authorService->syncAuthors($preferredAuthor, $secondaryAuthors, $book);

        $book->save();
        return $book;
    }

    /**
     * @param UpdateBookAuthorRequest $updateBookAuthorRequest
     * @return array
     */
    private function saveSecondaryAuthors(UpdateBookAuthorRequest $updateBookAuthorRequest)
    {
        $secondaryAuthors = [];
        foreach ($updateBookAuthorRequest->getSecondaryAuthors() as $secondaryAuthor) {
            $author = $this->authorService->createOrFindAuthor($secondaryAuthor);
            array_push($secondaryAuthors, $author);
        }
        return $secondaryAuthors;
    }

}