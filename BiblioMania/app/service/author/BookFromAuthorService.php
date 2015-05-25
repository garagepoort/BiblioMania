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
        Book::where('book_from_author_id', '=', $id)->update(array('book_from_author_id' => null));
        $bookFromAuthor = BookFromAuthor::find($id);
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