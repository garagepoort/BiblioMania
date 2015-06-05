<?php

class OeuvreService
{
    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;

    function __construct()
    {
        $this->bookFromAuthorRepository = App::make("BookFromAuthorRepository");
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
                $bookFromAuthor->author_id = $authorId;
                $bookFromAuthor->title = $bookFromAuthorParameters->getTitle();
                $bookFromAuthor->publication_year = $bookFromAuthorParameters->getYear();
                $this->bookFromAuthorRepository->save($bookFromAuthor);
            }
        }
    }
}