<?php

class OeuvreService
{
    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;
    /** @var BookRepository */
    private $bookRepository;

    function __construct()
    {
        $this->bookFromAuthorRepository = App::make("BookFromAuthorRepository");
        $this->bookRepository = App::make("BookRepository");
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

    public function saveBookFromAuthors($oeuvreList, $authorId){
        /** @var BookFromAuthorParameters $bookFromAuthorParameters */
        foreach($oeuvreList as $bookFromAuthorParameters){
            $foundBookFromAuthor = BookFromAuthor::where('title', '=', $bookFromAuthorParameters->getTitle())->where('author_id', '=', $authorId)->first();
            if (is_null($foundBookFromAuthor)) {
                $bookFromAuthor = new BookFromAuthor();
//                $bookFromAuthor->author_id = $authorId;
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

    public function linkBookToBookFromAuthor($book_id, $book_from_author_id){
        $book = $this->bookRepository->find($book_id, array("authors"));
        $bookFromAuthor = $this->bookFromAuthorRepository->find($book_from_author_id, array("author"));

        if($book == null){
            throw new ServiceException("Book not found");
        }
        if($bookFromAuthor == null){
            throw new ServiceException("BookFromAuthor not found");
        }
        if($book->preferredAuthor()->id != $bookFromAuthor->author->id){
            throw new ServiceException("Author is not the same for book and oeuvreItem");
        }

        $this->bookRepository->setBookFromAuthor($book, $bookFromAuthor);
    }
}