<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class BookFromAuthorService
{
    /** @var  OeuvreItemRepository */
    private $oeuvreItemRepository;
    /** @var  AuthorRepository */
    private $authorRepository;

    function __construct()
    {
        $this->oeuvreItemRepository = App::make('OeuvreItemRepository');
        $this->authorRepository = App::make('AuthorRepository');
    }


    public function save($author_id, $title, $year)
    {
        $oeuvreItem = $this->oeuvreItemRepository->findByTitle($author_id, $title);
        $author = $this->authorRepository->find($author_id);

        if($oeuvreItem != null){
            throw new ServiceException("Oeuvre item met deze titel bestaat al.");
        }
        if($author == null){
            throw new ServiceException("Auteur bestaat niet.");
        }

        $oeuvreItem = new BookFromAuthor(array(
            'title' => $title,
            'publication_year' => $year,
            'author_id' => $author_id
        ));

        $this->oeuvreItemRepository->save($oeuvreItem);
        return $oeuvreItem;
    }

    public function delete($id)
    {
        $oeuvreItem = $this->oeuvreItemRepository->find($id);
        if(is_null($oeuvreItem)){
            throw new ServiceException("Book from author not found");
        }
        if(count($oeuvreItem->books)>0){
            throw new ServiceException("Not allowed to delete book from author. Still has books linked to it.");
        }
        $oeuvreItem->delete();
    }

    public function edit($id, $title, $year)
    {
        $oeuvreItem = $this->oeuvreItemRepository->find($id);
        if($oeuvreItem == null){
            throw new ServiceException("Oeuvre item bestaat niet");
        }
        $oeuvreItem->title = $title;
        $oeuvreItem->publication_year = $year;
        $oeuvreItem->save();
    }

    public function updateTitle($id, $title)
    {
        $bookFromAuthor = $this->oeuvreItemRepository->find($id);
        if($bookFromAuthor == null){
            throw new ServiceException("Oeuvre item bestaat niet");
        }
        if ($bookFromAuthor != null) {
            $bookFromAuthor->title = $title;
            $bookFromAuthor->save();
        }
    }

    public function updateYear($id, $year)
    {
        $bookFromAuthor = $this->oeuvreItemRepository->find($id);
        if($bookFromAuthor == null){
            throw new ServiceException("Oeuvre item bestaat niet");
        }
        if ($bookFromAuthor != null) {
            $bookFromAuthor->publication_year = $year;
            $bookFromAuthor->save();
        }
    }

    public function find($title, $author_id)
    {
        $bookFromAuthor = $this->oeuvreItemRepository->findByTitle($author_id, $title);

        if(is_null($bookFromAuthor)){
            throw new ServiceException("BookFromAuthor not found");
        }

        return $bookFromAuthor;
    }
}