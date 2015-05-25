<?php

class BookFromAuthorService
{

    public function save($author_id, $title, $year)
    {
        $bookFromAuthor = new BookFromAuthor(array(
            'title' => $title,
            'publication_year' => $year,
            'author_id' => $author_id
        ));
        $bookFromAuthor->save();
        return $bookFromAuthor;
    }

    public function delete($id)
    {
        $bookFromAuthor = BookFromAuthor::find($id);
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
        $bookFromAuthor = BookFromAuthor::find($id);
        $bookFromAuthor->title = $title;
        $bookFromAuthor->publication_year = $year;
        $bookFromAuthor->save();
    }

    public function updateTitle($id, $title)
    {
        $bookFromAuthor = BookFromAuthor::find($id);
        if ($bookFromAuthor != null) {
            $bookFromAuthor->title = $title;
            $bookFromAuthor->save();
        }
    }

    public function updateYear($id, $year)
    {
        $bookFromAuthor = BookFromAuthor::find($id);
        if ($bookFromAuthor != null) {
            $bookFromAuthor->publication_year = $year;
            $bookFromAuthor->save();
        }
    }

    public function find($title, $author_id)
    {
        $bookFromAuthor = BookFromAuthor::where("title", "=", $title)
            ->where("author_id", "=", $author_id)
            ->first();

        if(is_null($bookFromAuthor)){
            throw new ServiceException("BookFromAuthor not found");
        }

        return $bookFromAuthor;
    }
}