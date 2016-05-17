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
        $bookFromAuthor = $this->oeuvreItemRepository->findByTitle($author_id, $title);
        $author = $this->authorRepository->find($author_id);

        if($bookFromAuthor != null){
            throw new ServiceException("Oeuvre item met deze titel bestaat al.");
        }
        if($author == null){
            throw new ServiceException("Auteur bestaat niet.");
        }

        $bookFromAuthor = new BookFromAuthor(array(
            'title' => $title,
            'publication_year' => $year,
            'author_id' => $author_id
        ));

        $this->oeuvreItemRepository->save($bookFromAuthor);
        return $bookFromAuthor;
    }

    public function delete($id)
    {
        $bookFromAuthor = $this->oeuvreItemRepository->find($id);
        if(is_null($bookFromAuthor)){
            throw new ServiceException("Book from author not found");
        }
        if(count($bookFromAuthor->books)>0){
            throw new ServiceException("Not allowed to delete book from author. Still has books linked to it.");
        }
        $bookFromAuthor->delete();
    }

    public function edit($id, $title, $year)
    {
        $bookFromAuthor = $this->oeuvreItemRepository->find($id);
        if($bookFromAuthor == null){
            throw new ServiceException("Oeuvre item bestaat niet");
        }
        $bookFromAuthor->title = $title;
        $bookFromAuthor->publication_year = $year;
        $bookFromAuthor->save();
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