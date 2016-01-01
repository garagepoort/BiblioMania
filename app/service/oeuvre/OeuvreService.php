<?php

class OeuvreService
{
    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;
    /** @var BookRepository */
    private $bookRepository;
    /** @var  AuthorRepository */
    private $authorRepository;
    /** @var  OeuvreItemLinkValidator */
    private $oeuvreItemLinkValidator;

    function __construct()
    {
        $this->bookFromAuthorRepository = App::make("BookFromAuthorRepository");
        $this->bookRepository = App::make("BookRepository");
        $this->authorRepository = App::make("AuthorRepository");
        $this->oeuvreItemLinkValidator = App::make("OeuvreItemLinkValidator");
    }

    public function linkNewOeuvreFromAuthor($author_id, $oeuvreText)
    {
        if (!empty($oeuvreText)) {
            $titles = explode("\n", $oeuvreText);
            $bookFromAuthorService = App::make('BookFromAuthorService');

            foreach ($titles as $title) {
                $res = explode(" - ", $title);
                $bookFromAuthorService->save($author_id, $res[1], $res[0]);
            }
        }
    }

    public function linkBookToOeuvreItem($oeuvreId, BookIdRequest $bookToOeuvreItemRequest){
        /** @var BookFromAuthor $oeuvreItem */
        $oeuvreItem = $this->find($oeuvreId);
        Ensure::objectNotNull("oeuvre item", $oeuvreItem);

        /** @var Book $book */
        $book = $this->bookRepository->find($bookToOeuvreItemRequest->getBookId(), array('authors'));
        Ensure::objectNotNull("book", $book);

        $this->oeuvreItemLinkValidator->validate($oeuvreItem, $book);

        $book->book_from_authors()->attach($oeuvreId);
        $book->save();
    }

    public function deleteLinkedBookFromOeuvreItem($oeuvreId, BookIdRequest $bookToOeuvreItemRequest){
        /** @var BookFromAuthor $oeuvreItem */
        $oeuvreItem = $this->find($oeuvreId);
        Ensure::objectNotNull("oeuvre item", $oeuvreItem);
        $book = $this->bookRepository->find($bookToOeuvreItemRequest->getBookId());
        Ensure::objectNotNull("book", $book);

        $book->book_from_authors()->detach($oeuvreId);
        $book->save();
    }

    public function saveBookFromAuthors($oeuvreList, $authorId){
        /** @var BookFromAuthorParameters $bookFromAuthorParameters */
        foreach($oeuvreList as $bookFromAuthorParameters){
            $foundBookFromAuthor = BookFromAuthor::where('title', '=', $bookFromAuthorParameters->getTitle())->where('author_id', '=', $authorId)->first();
            if (is_null($foundBookFromAuthor)) {
                $bookFromAuthor = new BookFromAuthor();
                $bookFromAuthor->author_id = $authorId;
                $bookFromAuthor->title = $bookFromAuthorParameters->getTitle();
                $bookFromAuthor->publication_year = $bookFromAuthorParameters->getYear();
                $this->bookFromAuthorRepository->save($bookFromAuthor);
            }
        }
    }

    public function editBookFromAuthors($oeuvreList, $authorId){
        /** @var BookFromAuthorParameters $bookFromAuthorParameters */
        foreach($oeuvreList as $bookFromAuthorParameters){
            $foundBookFromAuthor = BookFromAuthor::where('id', '=', $bookFromAuthorParameters->getId())->where('author_id', '=', $authorId)->first();
            if (is_null($foundBookFromAuthor)) {
                throw new ServiceException("Oeuvre item met id: " . $bookFromAuthorParameters->getId() . " niet gevonden,.");
            }else{
                $foundBookFromAuthor->id = $bookFromAuthorParameters->getId();
                $foundBookFromAuthor->author_id = $authorId;
                $foundBookFromAuthor->title = $bookFromAuthorParameters->getTitle();
                $foundBookFromAuthor->publication_year = $bookFromAuthorParameters->getYear();
                $this->bookFromAuthorRepository->save($foundBookFromAuthor);
            }
        }
    }

    public function saveOeuvreItem(CreateOeuvreItemRequest $createRequest)
    {
        $author = $this->authorRepository->find($createRequest->getAuthorId());
        if($author == null){
            throw new ServiceException("Author not found");
        }
        /** @var BookFromAuthor $oeuvreItem */
        $oeuvreItem = new BookFromAuthor();
        $oeuvreItem->author_id = $createRequest->getAuthorId();
        $oeuvreItem->publication_year = $createRequest->getPublicationYear();
        $oeuvreItem->title = $createRequest->getTitle();
        $oeuvreItem->save();
    }

    public function deleteOeuvreItem($id)
    {
        $item = $this->bookFromAuthorRepository->find($id);
        Ensure::objectNotNull("Oeuvre item", $item);
        if(count($item->books)>0){
            throw new ServiceException("Not allowed to delete book from author. Still has books linked to it.");
        }
        $item->delete();
    }

    public function updateOeuvreItem(UpdateOeuvreItemRequest $oeuvreItemRequest){
        /** @var BookFromAuthor $oeuvreItem */
        $oeuvreItem = $this->bookFromAuthorRepository->find($oeuvreItemRequest->getId());
        $author = $this->authorRepository->find($oeuvreItemRequest->getAuthorId());

        Ensure::objectNotNull("Oeuvre item", $oeuvreItem);
        Ensure::objectNotNull("Author", $author);

        $oeuvreItem->title = $oeuvreItemRequest->getTitle();
        $oeuvreItem->author_id = $oeuvreItemRequest->getAuthorId();
        $oeuvreItem->publication_year = $oeuvreItemRequest->getPublicationYear();

        $oeuvreItem->save();
    }

    public function find($id)
    {
        return $this->bookFromAuthorRepository->find($id);
    }
}