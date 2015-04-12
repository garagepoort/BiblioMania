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
        foreach($oeuvreList as $oeuvre){
            $oeuvre->author_id = $authorId;
            $this->bookFromAuthorRepository->save($oeuvre);
        }
    }
}